<?php

namespace App\Console\Commands;

use App\Models\Division;
use App\Models\Department;
use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExportOrgJSONL extends Command
{
    protected $signature = 'export:org-jsonl
                            {--langs=ru,kz,en : Комма-разделённый список языков}
                            {--only= : Только один тип: divisions|departments}';
    protected $description = 'Экспорт Division и Department в JSONL (удобно для RAG) без перезаписи между типами';

    public function handle()
    {
        $langs = array_values(array_filter(array_map('trim', explode(',', $this->option('langs') ?? 'ru,kz,en'))));
        $only = $this->option('only'); // null | divisions | departments

        // Базовые директории
        $baseDir = 'jsonl';
        $byLangDir = $baseDir . '/by-lang';
        Storage::disk('public')->makeDirectory($baseDir);
        Storage::disk('public')->makeDirectory($byLangDir);

        // Открываем потоки
        $streams = [
            'all' => $this->openStream($baseDir . '/all.jsonl'),
            'divisions' => $this->openStream($baseDir . '/divisions.jsonl'),
            'departments' => $this->openStream($baseDir . '/departments.jsonl'),
        ];
        $byLangStreams = [
            'divisions' => [],
            'departments' => [],
        ];
        foreach ($langs as $lang) {
            $byLangStreams['divisions'][$lang] = $this->openStream("{$byLangDir}/divisions_{$lang}.jsonl");
            $byLangStreams['departments'][$lang] = $this->openStream("{$byLangDir}/departments_{$lang}.jsonl");
        }

        $totalAll = 0;
        $counts = ['divisions' => 0, 'departments' => 0];

        // ===== Export Divisions =====
        if (!$only || $only === 'divisions') {
            $divisions = Division::all();
            foreach ($divisions as $division) {
                foreach ($langs as $lang) {
                    $rec = $this->buildDivisionRecord($division, $lang);
                    $line = json_encode($rec, JSON_UNESCAPED_UNICODE) . "\n";

                    fwrite($streams['divisions'], $line);
                    fwrite($byLangStreams['divisions'][$lang], $line);
                    fwrite($streams['all'], json_encode(['type' => 'division'] + $rec, JSON_UNESCAPED_UNICODE) . "\n");

                    $counts['divisions']++;
                    $totalAll++;
                }
            }
            $this->info("Divisions exported: {$counts['divisions']}");
        }

        // ===== Export Departments =====
        if (!$only || $only === 'departments') {
            $departments = Department::all();
            foreach ($departments as $department) {
                foreach ($langs as $lang) {
                    $rec = $this->buildDepartmentRecord($department, $lang);
                    $line = json_encode($rec, JSON_UNESCAPED_UNICODE) . "\n";

                    fwrite($streams['departments'], $line);
                    fwrite($byLangStreams['departments'][$lang], $line);
                    fwrite($streams['all'], json_encode(['type' => 'department'] + $rec, JSON_UNESCAPED_UNICODE) . "\n");

                    $counts['departments']++;
                    $totalAll++;
                }
            }
            $this->info("Departments exported: {$counts['departments']}");
        }

        // Закрываем
        foreach ($streams as $s) {
            fclose($s);
        }
        foreach ($byLangStreams as $arr) {
            foreach ($arr as $s) fclose($s);
        }

        $this->info("ALL exported: {$totalAll}");
        $this->info("Combined all.jsonl: storage/app/public/{$baseDir}/all.jsonl");
        $this->info("Divisions: storage/app/public/{$baseDir}/divisions.jsonl");
        $this->info("Departments: storage/app/public/{$baseDir}/departments.jsonl");
        foreach ($langs as $lang) {
            $this->info("By-lang divisions_{$lang}.jsonl & departments_{$lang}.jsonl -> storage/app/public/{$byLangDir}");
        }

        return self::SUCCESS;
    }

    /* -------------------- Builders -------------------- */

    private function buildDivisionRecord($division, string $lang): array
    {
        $nameField = "name_{$lang}";
        $descField = "description_{$lang}";
        $contactsField = "contacts_{$lang}";
        $slugField = "slug_{$lang}";

        $title = (string)($division->$nameField ?? '');
        $slug = $division->$slugField ?? (Str::slug($title) ?: ('division-' . $division->id));

        $rawDescription = (string)($division->$descField ?? '');
        $cleanHtml = $this->cleanDescription($rawDescription);
        $text = $this->htmlToText($cleanHtml);

        $contactsRaw = $division->$contactsField ?? [];
        $contacts = $this->normalizeContacts($contactsRaw);

        return [
            'doc_id' => "division:{$division->id}:{$lang}",
            'id' => (int)$division->id,
            'lang' => $lang,
            'slug' => $slug,
            'title' => $title,
            'text' => $text,
            'contacts' => $contacts,
        ];
    }

    private function buildDepartmentRecord($department, string $lang): array
    {
        $nameField = "name_{$lang}";
        $descField = "description_{$lang}";
        $contactsField = "contacts_{$lang}";

        $title = (string)($department->$nameField ?? '');
        $slug = Str::slug($title) ?: ('department-' . $department->id);

        $rawDescription = (string)($department->$descField ?? '');
        $cleanHtml = $this->cleanDescription($rawDescription);
        $text = $this->htmlToText($cleanHtml);

        $contactsRaw = $department->$contactsField ?? [];
        $contacts = $this->normalizeContacts($contactsRaw);

        $staff = $this->normalizeStaff($department->staff ?? [], $lang);

        return [
            'doc_id' => "department:{$department->id}:{$lang}",
            'id' => (int)$department->id,
            'lang' => $lang,
            'slug' => $slug,
            'title' => $title,
            'text' => $text,
            'contacts' => $contacts,
            'staff' => $staff,
        ];
    }

    /* -------------------- Helpers -------------------- */

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

    private function normalizeStaff($staffRaw, string $lang): array
    {
        if (is_object($staffRaw) && method_exists($staffRaw, 'toArray')) {
            $staffRaw = $staffRaw->toArray();
        }
        if (!is_array($staffRaw)) return [];

        $nameKey = "name_{$lang}";
        $posKey = "position_{$lang}";
        $out = [];

        foreach ($staffRaw as $person) {
            if (is_object($person) && method_exists($person, 'toArray')) {
                $person = $person->toArray();
            }
            $out[] = [
                'name' => (string)($person[$nameKey] ?? ''),
                'position' => (string)($person[$posKey] ?? ''),
                'email' => (string)($person['email'] ?? ''),
                'phone' => (string)($person['phone'] ?? ''),
            ];
        }
        return $out;
    }

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
