<?php

namespace App\Console\Commands;

use App\Models\Division;
use Barryvdh\DomPDF\Facade\Pdf;
use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateDivisionsPDF extends Command
{
    protected $signature = 'generate:divisions-pdf';
    protected $description = 'Generate PDFs for all divisions in multiple languages and export code to TXT';

    public function handle()
    {
        $divisions = Division::all();
        $langs = ['ru', 'kz', 'en']; // используем kk вместо kz

        // Подготавливаем директории
        $baseDir = 'jsonl';
        $byLangDir = $baseDir . '/by-lang';
        Storage::disk('public')->makeDirectory($baseDir);
        Storage::disk('public')->makeDirectory($byLangDir);

        // Пути файлов
        $combinedPath = $baseDir . '/divisions.jsonl';

        // Открываем общий файл на запись (перезаписываем)
        $combinedStream = $this->openStream($combinedPath);

        // Откроем по языкам (перезаписываем)
        $langStreams = [];
        foreach ($langs as $lang) {
            $langPath = "{$byLangDir}/{$lang}.jsonl";
            $langStreams[$lang] = $this->openStream($langPath);
        }

        $count = 0;

        foreach ($divisions as $division) {
            foreach ($langs as $lang) {
                $nameField = "name_{$lang}";
                $descField = "description_{$lang}";
                $contactsField = "contacts_{$lang}";
                $slugField = "slug_{$lang}";

                $title = (string)($division->$nameField ?? '');
                $slug = $division->$slugField ?? Str::slug($title) ?: ('division-' . $division->id);

                // Чистим HTML -> в текст
                $rawDescription = (string)($division->$descField ?? '');
                $cleanHtml = $this->cleanDescription($rawDescription);
                $text = $this->htmlToText($cleanHtml);

                // Контакты -> массив/объект
                $contactsRaw = $division->$contactsField ?? [];
                $contacts = $this->normalizeContacts($contactsRaw);

                // Стабильный doc_id
                $docId = "division:{$division->id}:{$lang}";

                // Объект JSONL
                $record = [
                    'doc_id' => $docId,
                    'id' => (int)$division->id,
                    'lang' => $lang,
                    'slug' => $slug,
                    'title' => $title,
                    'text' => $text,
                    'contacts' => $contacts,
                ];

                $line = json_encode($record, JSON_UNESCAPED_UNICODE) . "\n";

                // Пишем в общий и языковой файл
                fwrite($combinedStream, $line);
                fwrite($langStreams[$lang], $line);

                $count++;
            }
        }

        // Закрываем все потоки
        fclose($combinedStream);
        foreach ($langStreams as $stream) {
            fclose($stream);
        }

        $this->info("Exported {$count} JSONL records.");
        $this->info("Combined: storage/app/public/{$combinedPath}");
        foreach ($langs as $lang) {
            $this->info("By-lang ({$lang}): storage/app/public/{$byLangDir}/{$lang}.jsonl");
        }

        return self::SUCCESS;
    }

    /**
     * Удаляем <img>, <video>, <audio>, <iframe>, <source>, <picture>.
     * Возвращаем безопасный HTML.
     */
    private function cleanDescription(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML(
            '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' .
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8') .
            '</body></html>'
        );

        $tagsToRemove = ['img', 'video', 'audio', 'iframe', 'source', 'picture'];
        foreach ($tagsToRemove as $tag) {
            while (true) {
                $nodes = $doc->getElementsByTagName($tag);
                if ($nodes->length === 0) break;
                $node = $nodes->item(0);
                if ($node && $node->parentNode) {
                    $node->parentNode->removeChild($node);
                } else {
                    break;
                }
            }
        }

        $body = $doc->getElementsByTagName('body')->item(0);
        if (!$body) return '';

        $cleanHtml = '';
        foreach ($body->childNodes as $child) {
            $cleanHtml .= $doc->saveHTML($child);
        }

        return $cleanHtml ?: '';
    }

    /**
     * Переводим HTML в плоский текст:
     * - убираем теги
     * - нормализуем пробелы и переносы
     */
    private function htmlToText(string $html): string
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        // Нормализация переносов и пробелов
        $text = preg_replace("/\r\n|\r/", "\n", $text);
        $text = preg_replace("/[ \t]+\n/", "\n", $text);   // пробелы в конце строк
        $text = preg_replace("/\n{3,}/", "\n\n", $text);   // слишком много пустых строк
        $text = preg_replace("/[ \t]{2,}/", " ", $text);   // подряд идущие пробелы

        return trim($text);
    }

    /**
     * Привести контакты к массиву/объекту:
     * - если коллекция/модель -> toArray()
     * - если JSON-строка -> json_decode
     * - если строка с разделителями -> в массив
     * - иначе как есть (скаляр/null)
     */
    private function normalizeContacts($contacts)
    {
        // Коллекции / модели
        if (is_object($contacts) && method_exists($contacts, 'toArray')) {
            $contacts = $contacts->toArray();
        }

        // JSON-строка?
        if (is_string($contacts)) {
            $trimmed = trim($contacts);
            if ($trimmed !== '') {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $contacts = $decoded;
                } else {
                    // Попробуем простую разбивку по переводам строк или точкам с запятыми
                    $parts = preg_split('/\r\n|\r|\n|;/', $trimmed);
                    $parts = array_values(array_filter(array_map('trim', $parts), fn($v) => $v !== ''));
                    if (count($parts) > 1) {
                        $contacts = $parts;
                    }
                }
            }
        }

        return $contacts;
    }

    /**
     * Открыть поток для файла в диске public, перезаписывая его.
     */
    private function openStream(string $path)
    {
        // Убедимся, что директория существует
        $dir = dirname($path);
        Storage::disk('public')->makeDirectory($dir);

        // Получим абсолютный путь
        $fullPath = Storage::disk('public')->path($path);

        $stream = fopen($fullPath, 'w');
        if ($stream === false) {
            throw new \RuntimeException("Cannot open file for writing: {$fullPath}");
        }
        return $stream;
    }
}
