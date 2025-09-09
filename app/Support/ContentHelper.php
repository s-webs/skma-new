<?php

namespace App\Support;

use DOMDocument;

class ContentHelper
{
    public static function absolutizeUrl(?string $url, string $base): string
    {
        $u = trim((string)$url);
        if ($u === '') return '';

        if (str_starts_with($u, 'data:image')) return $u; // data:
        if (preg_match('#^https?://#i', $u)) return $u; // http/https
        if (str_starts_with($u, '//')) return 'https:' . $u; // //example.com

        return rtrim($base, '/') . '/' . ltrim($u, '/'); // относительный
    }

    public static function extractImageSrcsFromHtml(string $html): array
    {
        $images = [];
        if (trim($html) === '') return $images;

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');

            if (!$src) $src = $img->getAttribute('data-src');
            if (!$src && $img->hasAttribute('data-srcset')) {
                $first = trim(explode(',', $img->getAttribute('data-srcset'))[0]);
                $src = trim(explode(' ', $first)[0]);
            }
            if (!$src && $img->hasAttribute('srcset')) {
                $first = trim(explode(',', $img->getAttribute('srcset'))[0]);
                $src = trim(explode(' ', $first)[0]);
            }

            if ($src) $images[] = $src;
        }
        return $images;
    }

    public static function cleanHtmlToText(string $html): string
    {
        $clean = preg_replace('#<(script|style)\b[^<]*(?:(?!</\1>)<[^<]*)*</\1>#si', '', $html);
        $clean = strip_tags($clean);
        $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5);
        return trim(preg_replace('/\s+/u', ' ', $clean));
    }

    public static function buildImagesList(string $preview, array $contentSrcs, string $base): array
    {
        $images = [];
        if ($preview !== '') {
            $images[] = self::absolutizeUrl($preview, $base);
        }
        foreach ($contentSrcs as $u) {
            $images[] = self::absolutizeUrl($u, $base);
        }
        // убираем дубли, сохраняя порядок
        return array_values(array_unique(array_filter($images)));
    }
}
