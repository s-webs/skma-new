<?php

namespace App\Console\Commands;

use App\Models\Department;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExportDepartments extends Command
{
    protected $signature = 'export:departments';
    protected $description = 'Экспорт кафедр (Department) в txt файлы для ru/kz/en';

    public function handle()
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            $this->exportDepartment($department, 'ru');
            $this->exportDepartment($department, 'kz');
            $this->exportDepartment($department, 'en');
        }

        $this->info('✅ Экспорт кафедр завершён!');
    }

    private function exportDepartment(Department $department, string $lang)
    {
        $name     = $department->{"name_$lang"};
        $rawDesc  = $department->{"description_$lang"};
        $contacts = $department->{"contacts_$lang"};
        $slug     = $department->{"slug_$lang"};

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
        $lines   = [];
        $lines[] = "Название";
        $lines[] = trim($name);
        $lines[] = "";
        $lines[] = "Описание:";
        $lines[] = trim($description);
        $lines[] = "";

        // Сотрудники
        if ($department->staff) {
            $lines[] = "Сотрудники";
            foreach ($department->staff as $employee) {
                $ename    = trim($employee["name_{$lang}"] ?? '');
                $position = trim($employee["position_{$lang}"] ?? '');
                $email    = trim($employee["email"] ?? '');
                $phone    = trim($employee["phone"] ?? '');

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

        // Собираем текст и убираем пробелы вокруг строк
        $content = implode("\n", array_map('trim', $lines)) . "\n";

        // Путь для сохранения
        $dir  = "dataAi/txt/{$lang}/departments";
        $path = "{$dir}/{$name}.txt";

        Storage::disk('public')->makeDirectory($dir);
        Storage::disk('public')->put($path, $content);

        $this->line("✅ <fg=blue>[{$lang}]</> {$name} → storage/app/public/{$path}");
    }
}
