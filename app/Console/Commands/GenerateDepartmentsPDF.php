<?php

namespace App\Console\Commands;

use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;
use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateDepartmentsPDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:departments-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $departments = Department::all();
        $langs = ['ru', 'kz', 'en']; // используем kz

        // Директории
        $baseDir = 'jsonl';
        $byLangDir = $baseDir . '/by-lang';
        Storage::disk('public')->makeDirectory($baseDir);
        Storage::disk('public')->makeDirectory($byLangDir);

        // Пути
        $combinedPath = $baseDir . '/departments.jsonl';

        // Потоки
        $combinedStream = $this->openStream($combinedPath);
        $langStreams = [];
        foreach ($langs as $lang) {
            $langStreams[$lang] = $this->openStream("{$byLangDir}/{$lang}.jsonl");
        }

        $count = 0;

        foreach ($departments as $department) {
            foreach ($langs as $lang) {
                $nameField = "name_{$lang}";
                $descField = "description_{$lang}";
                $contactsField = "contacts_{$lang}";

                $title = (string)($department->$nameField ?? '');
                $slug = Str::slug($title) ?: ('department-' . $department->id);

                // Описание: чистим HTML -> текст
                $rawDescription = (string)($department->$descField ?? '');
                $cleanHtml = $this->cleanDescription($rawDescription);
                $text = $this->htmlToText($cleanHtml);

                // Контакты нормализуем
                $contactsRaw = $department->$contactsField ?? [];
                $contacts = $this->normalizeContacts($contactsRaw);

                // Сотрудники (staff) нормализуем под язык
                $staff = $this->normalizeStaff($department->staff ?? [], $lang);

                // Стабильный doc_id
                $docId = "department:{$department->id}:{$lang}";

                $record = [
                    'doc_id' => $docId,
                    'id' => (int)$department->id,
                    'lang' => $lang,
                    'slug' => $slug,
                    'title' => $title,
                    'text' => $text,
                    'contacts' => $contacts,
                    'staff' => $staff,
                ];

                $line = json_encode($record, JSON_UNESCAPED_UNICODE) . "\n";

                fwrite($combinedStream, $line);
                fwrite($langStreams[$lang], $line);

                $count++;
            }
        }

        fclose($combinedStream);
        foreach ($langStreams as $s) fclose($s);

        $this->info("Exported {$count} JSONL records.");
        $this->info("Combined: storage/app/public/{$combinedPath}");
        foreach ($langs as $lang) {
            $this->info("By-lang ({$lang}): storage/app/public/{$byLangDir}/{$lang}.jsonl");
        }

        return self::SUCCESS;
    }

    /**
     * Чистим потенциально «грязный» HTML:
     * удаляем <img>, <video>, <audio>, <iframe>, <source>, <picture>.
     */
    private function cleanDescription(string $html): string
    {
        $html = trim($html);
        if ($html === '') return '';

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
     * HTML -> текст, нормализация переносов/пробелов.
     */
    private function htmlToText(string $html): string
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $text = preg_replace("/\r\n|\r/", "\n", $text);
        $text = preg_replace("/[ \t]+\n/", "\n", $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);
        $text = preg_replace("/[ \t]{2,}/", " ", $text);
        return trim($text);
    }

    /**
     * Контакты к удобному формату:
     * - коллекции/модели -> toArray()
     * - JSON-строка -> в массив
     * - строка с разделителями -> массив строк
     */
    private function normalizeContacts($contacts)
    {
        if (is_object($contacts) && method_exists($contacts, 'toArray')) {
            $contacts = $contacts->toArray();
        }

        if (is_string($contacts)) {
            $trimmed = trim($contacts);
            if ($trimmed !== '') {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $decoded;
                }
                $parts = preg_split('/\r\n|\r|\n|;/', $trimmed);
                $parts = array_values(array_filter(array_map('trim', $parts), fn($v) => $v !== ''));
                if (count($parts) > 1) return $parts;
            }
        }

        return $contacts;
    }

    /**
     * Приводим staff к массиву объектов нужного языка.
     * Ожидаем структуру элементов staff с ключами name_{lang}, position_{lang}, email, phone.
     */
    private function normalizeStaff($staffRaw, string $lang): array
    {
        // Если коллекция/модель
        if (is_object($staffRaw) && method_exists($staffRaw, 'toArray')) {
            $staffRaw = $staffRaw->toArray();
        }

        if (!is_array($staffRaw)) {
            return [];
        }

        $out = [];
        foreach ($staffRaw as $person) {
            // допускаем как массивы, так и объекты
            if (is_object($person) && method_exists($person, 'toArray')) {
                $person = $person->toArray();
            }

            $nameKey = "name_{$lang}";
            $posKey = "position_{$lang}";

            $out[] = [
                'name' => (string)($person[$nameKey] ?? ''),
                'position' => (string)($person[$posKey] ?? ''),
                'email' => (string)($person['email'] ?? ''),
                'phone' => (string)($person['phone'] ?? ''),
            ];
        }
        return $out;
    }

    /**
     * Открыть поток для файла в диске public (перезапись).
     */
    private function openStream(string $path)
    {
        $dir = dirname($path);
        Storage::disk('public')->makeDirectory($dir);
        $fullPath = Storage::disk('public')->path($path);
        $stream = fopen($fullPath, 'w');
        if ($stream === false) {
            throw new \RuntimeException("Cannot open file for writing: {$fullPath}");
        }
        return $stream;
    }
}
