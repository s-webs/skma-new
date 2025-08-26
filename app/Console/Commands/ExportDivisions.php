<?php

namespace App\Console\Commands;

use App\Models\Division;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportDivisions extends Command
{
    protected $signature = 'export:divisions';
    protected $description = 'Экспорт подразделений (Division) в txt файлы для ru/kz/en';

    public function handle()
    {
        $divisions = Division::all();

        foreach ($divisions as $division) {
            $this->exportDivision($division, 'ru');
            $this->exportDivision($division, 'kz');
            $this->exportDivision($division, 'en');
        }

        $this->info('✅ Экспорт подразделений завершён!');
    }

    private function exportDivision(Division $division, string $lang)
    {
        $name = trim($division->{"name_$lang"});
        $rawDesc = $division->{"description_$lang"};
        $contacts = $division->{"contacts_$lang"};
        $slug = $division->{"slug_$lang"};

        // Описание
        if ($rawDesc) {
            $description = html_entity_decode(strip_tags($rawDesc), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $description = str_replace('•', '-', $description);
            $description = preg_replace('/\s+/', ' ', $description);
            $description = trim($description);
        } else {
            $description = '-';
        }

        // Сбор строк
        $lines = [];
        $lines[] = "Название";
        $lines[] = $name;
        $lines[] = "";
        $lines[] = "Описание:";
        $lines[] = $description;
        $lines[] = "";

        // Сотрудники
        if ($division->staff) {
            $lines[] = "Сотрудники";
            foreach ($division->staff as $employee) {
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

        $lines[] = "Более подробную информацию вы можете получить по ссылке: https://new.skma.edu.kz/{$lang}/structure/{$slug}";

        $content = implode("\n", $lines) . "\n";

        // Путь для сохранения
        $dir = "dataAi/txt/{$lang}/divisions";
        $path = "{$dir}/{$name}.txt";

        Storage::disk('public')->makeDirectory($dir);
        Storage::disk('public')->put($path, $content);

        $this->line("✅ <fg=green>[{$lang}]</> {$name} → storage/app/public/{$path}");
    }
}
