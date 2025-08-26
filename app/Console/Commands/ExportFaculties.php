<?php

namespace App\Console\Commands;

use App\Models\Faculty;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportFaculties extends Command
{
    protected $signature = 'export:faculties';
    protected $description = 'Экспорт факультетов (Faculty) в txt файлы для ru/kz/en (в папку departments)';

    public function handle()
    {
        $faculties = Faculty::all();

        foreach ($faculties as $faculty) {
            $this->exportFaculty($faculty, 'ru');
            $this->exportFaculty($faculty, 'kz');
            $this->exportFaculty($faculty, 'en');
        }

        $this->info('✅ Экспорт факультетов завершён!');
    }

    private function exportFaculty(Faculty $faculty, string $lang)
    {
        $name = $faculty->{"name_$lang"} ?? '';
        $rawDesc = $faculty->{"description_$lang"} ?? '';
        $contacts = $faculty->{"contacts_$lang"} ?? [];
        $slug = $faculty->{"slug_$lang"};

        // Описание без html
        if ($rawDesc) {
            $description = html_entity_decode(strip_tags($rawDesc), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $description = str_replace('•', '-', $description);
            $description = preg_replace('/\s+/', ' ', $description);
            $description = trim($description);
        } else {
            $description = '-';
        }

        // Собираем текст
        $lines = [];
        $lines[] = "Название";
        $lines[] = trim($name);
        $lines[] = "";
        $lines[] = "Описание:";
        $lines[] = trim($description);
        $lines[] = "";

        // Сотрудники
        if ($faculty->staff) {
            $lines[] = "Сотрудники";
            foreach ($faculty->staff as $employee) {
                $ename = trim($employee["name_{$lang}"] ?? '');
                $position = trim($employee["position_{$lang}"] ?? '');
                $email = trim($employee["email"] ?? '');
                $phone = trim($employee["phone"] ?? '');

                $line = "- {$ename} ({$position})";
                if ($email) {
                    $line .= " | Email: {$email}";
                }
                if ($phone) {
                    $line .= " | Тел: {$phone}";
                }

                $lines[] = trim($line);
            }
            $lines[] = "";
        }

        // Контакты
        if ($contacts) {
            $lines[] = "Контакты";
            foreach ($contacts as $contact) {
                $label = trim($contact['key'] ?? '');
                $value = trim($contact['value'] ?? '');
                if ($label || $value) {
                    $lines[] = "- {$label} {$value}";
                }
            }
            $lines[] = "";
        }

        $lines[] = "Более подробную информацию вы можете получить по ссылке: https://new.skma.edu.kz/{$lang}/faculties/{$slug}";

        // Текст
        $content = implode("\n", array_map('trim', $lines)) . "\n";

        // Путь для сохранения (та же папка, что и Department)
        $dir = "dataAi/txt/{$lang}/departments";
        $path = "{$dir}/{$name}.txt";

        Storage::disk('public')->makeDirectory($dir);
        Storage::disk('public')->put($path, $content);

        $this->line("✅ <fg=yellow>[{$lang}]</> {$name} → storage/app/public/{$path}");
    }
}
