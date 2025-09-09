<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\ContentHelper;

class NewsResource extends JsonResource
{
    public function toArray($request): array
    {
        // язык из query (?lang=ru|kk|en)
        $rawLang = (string)$request->query('lang', 'ru');
        // для Carbon нужна именно kk/ru/en
        $carbonLocale = in_array($rawLang, ['ru', 'en', 'kk'], true) ? $rawLang : 'ru';

        $base = config('app.url', 'https://new.skma.edu.kz');

        $raw = (string)($this->text ?? '');

        $previewAbs = ContentHelper::absolutizeUrl((string)$this->preview, $base);
        $contentImgs = ContentHelper::extractImageSrcsFromHtml($raw);
        $images = ContentHelper::buildImagesList((string)$this->preview, $contentImgs, $base);

        return [
            'id' => (int)$this->id,
            'title' => (string)$this->title,
            'preview' => $previewAbs,
            'images' => $images,
            'text' => ContentHelper::cleanHtmlToText($raw),
            'slug' => (string)$this->slug,
            'views' => (int)$this->views,
            'author' => (string)$this->author,
            'created_at' => optional($this->created_at)->toISOString(),
            'created_at_formatted' => optional($this->created_at)
                ? $this->created_at->locale($carbonLocale)->translatedFormat('d F Y')
                : null,
            'likes_count' => (int)($this->likes_count ?? 0),
            'comments_count' => (int)($this->comments_count ?? 0),
            'liked' => (bool)($this->liked ?? false),
        ];
    }
}

