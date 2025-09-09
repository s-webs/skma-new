<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $lang = $request->get('lang', 'ru');
        $perPage = $request->get('per_page', 10);

        $paginator = News::select([
            'id',
            "title_$lang as title",
            "preview_$lang as preview",
            \DB::raw("text_$lang as text"), // сырое HTML
            "slug_$lang as slug",
            "views_$lang as views",
            'author',
            'created_at',
        ])
            ->withCount(['likes', 'comments'])
            ->orderByDesc('created_at')
            ->paginate($perPage);

        $base = config('app.url', 'https://new.skma.edu.kz'); // БАЗОВЫЙ ДОМЕН

        $paginator->getCollection()->transform(function ($item) use ($base) {
            $item->created_at = Carbon::parse($item->created_at)->format('d M Y');
            // -------- 1) Собираем <img> из СЫРОГО HTML --------
            $raw = (string)($item->text ?? '');
            $imagesFromContent = [];

            if (trim($raw) !== '') {
                $dom = new DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $raw);
                libxml_clear_errors();
                libxml_use_internal_errors(false);

                $imgs = $dom->getElementsByTagName('img');
                foreach ($imgs as $img) {
                    $src = $img->getAttribute('src');

                    // ленивые варианты
                    if (!$src) {
                        $src = $img->getAttribute('data-src');
                    }
                    if (!$src && $img->hasAttribute('data-srcset')) {
                        $srcset = $img->getAttribute('data-srcset');
                        $first = trim(explode(',', $srcset)[0]);
                        $src = trim(explode(' ', $first)[0]);
                    }

                    // srcset
                    if (!$src && $img->hasAttribute('srcset')) {
                        $srcset = $img->getAttribute('srcset'); // "url1 1x, url2 2x"
                        $first = trim(explode(',', $srcset)[0]);
                        $src = trim(explode(' ', $first)[0]);
                    }

                    if ($src) {
                        $imagesFromContent[] = $src;
                    }
                }
            }

            // -------- 2) Делаем preview абсолютным --------
            $item->preview = $this->absolutizeUrl((string)$item->preview, $base);

            // -------- 3) Формируем images: preview первым, затем контент --------
            $images = [];
            if (!empty($item->preview)) {
                $images[] = $item->preview; // preview всегда первый
            }

            // приводим контентные URL к абсолютным
            foreach ($imagesFromContent as $u) {
                $images[] = $this->absolutizeUrl($u, $base);
            }

            // удаляем дубли, сохраняем порядок (preview останется первым)
            $images = array_values(array_unique(array_filter($images)));

            // отдадим как поле images
            $item->setAttribute('images', $images);

            // -------- 4) Чистим текст от HTML --------
            $clean = $raw;
            // вырезать <script>/<style> целиком
            $clean = preg_replace(
                '#<(script|style)\b[^<]*(?:(?!</\1>)<[^<]*)*</\1>#si',
                '',
                $clean
            );
            $clean = strip_tags($clean);
            $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5);
            $clean = trim(preg_replace('/\s+/u', ' ', $clean));

            $item->text = $clean;

            return $item;
        });

        return response()->json($paginator);
    }

    /**
     * Превращает относительный/схемно-независимый URL в абсолютный.
     */
    private function absolutizeUrl(?string $url, string $base): string
    {
        $u = trim((string)$url);
        if ($u === '') {
            return '';
        }

        // data: изображения оставляем как есть
        if (str_starts_with($u, 'data:image')) {
            return $u;
        }

        // уже абсолютный (http/https)
        if (preg_match('#^https?://#i', $u)) {
            return $u;
        }

        // схемно-независимый //example.com/...
        if (str_starts_with($u, '//')) {
            return 'https:' . $u;
        }

        // относительный путь
        return rtrim($base, '/') . '/' . ltrim($u, '/');
    }

}
