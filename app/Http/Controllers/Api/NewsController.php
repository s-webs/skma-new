<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use DOMDocument;
use Illuminate\Http\Request;
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
            \DB::raw("text_$lang as text"), // сырое HTML содержимое
            "slug_$lang as slug",
            "views_$lang as views",
            'author',
            'created_at',
        ])
            ->withCount(['likes', 'comments'])
            ->orderByDesc('id')
            ->paginate($perPage);

        $paginator->getCollection()->transform(function ($item) {
            // 1) Собираем картинки ИЗ СЫРОГО HTML (до очистки)
            $raw = (string)($item->text ?? '');
            $imagesFromContent = [];

            if (trim($raw) !== '') {
                $dom = new DOMDocument();
                libxml_use_internal_errors(true);
                // префикс с encoding нужен, чтобы не сломать unicode
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $raw);
                libxml_clear_errors();

                $imgs = $dom->getElementsByTagName('img');
                foreach ($imgs as $img) {
                    $src = $img->getAttribute('src');

                    // поддержка ленивой загрузки
                    if (!$src) {
                        $src = $img->getAttribute('data-src');
                    }

                    // поддержка srcset: берём первый URL
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

            // 2) Формируем итоговый список: сначала preview, затем остальные (без дублей)
            $images = [];
            if (!empty($item->preview)) {
                $images[] = $item->preview;
            }
            foreach ($imagesFromContent as $url) {
                if (!in_array($url, $images, true)) {
                    $images[] = $url;
                }
            }

            // Если хочешь сделать абсолютные URL (вместо относительных),
            // раскомментируй и подставь базовый домен:
            //
            $base = config('https://new.skma.edu.kz'); // например, https://new.skma.edu.kz
            $images = array_map(function ($u) use ($base) {
                return preg_match('#^https?://#i', $u) ? $u : rtrim($base, '/') . '/' . ltrim($u, '/');
            }, $images);

            // Добавляем поле images в ответ
            $item->setAttribute('images', array_values($images));

            // 3) Чистим текст от HTML (как раньше)
            $clean = $raw;
            // вырезать полностью содержимое <script>/<style>
            $clean = preg_replace(
                '#<(script|style)\b[^<]*(?:(?!</\1>)<[^<]*)*</\1>#si',
                '',
                $clean
            );
            $clean = strip_tags($clean);                                   // убрать теги
            $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5);   // декодировать сущности
            $clean = trim(preg_replace('/\s+/u', ' ', $clean));            // нормализовать пробелы

            $item->text = $clean;

            return $item;
        });

        return response()->json($paginator);
    }

}
