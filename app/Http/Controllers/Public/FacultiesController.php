<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaravelLang\LocaleList\Locale;
use LaravelLang\Translator\Facades\Translate;

class FacultiesController extends Controller
{
    public function index()
    {
        $faculties = Faculty::query()->with('children')->get();

        return view('pages.faculties.index', compact('faculties'));
    }

    public function show($slug)
    {
        $localizedSlugColumn = 'slug_' . app()->getLocale();

        $item = Faculty::query()->where($localizedSlugColumn, $slug)->firstOr(function () use ($localizedSlugColumn, $slug) {
            return Department::query()->where($localizedSlugColumn, $slug)->firstOrFail();
        });

        $item->documents_ru = $item->transformDocuments($item->documents_ru);
        $item->documents_kz = $item->transformDocuments($item->documents_kz);
        $item->documents_en = $item->transformDocuments($item->documents_en);

        $lang = app()->getLocale();

        if ($item->umkd) {
            $umkd_files = scanDirectory($item->umkd, 'uploads', skipTopLevels: 1, maxDepth: 3);
            $item->umkd_files = $this->translateDirectoryNames($umkd_files);
        }

        if ($item->portfolio) {
            $portfolio_files = scanDirectory($item->portfolio, 'uploads', skipTopLevels: 1, maxDepth: 3);

            $item->portfolio_files = $portfolio_files;
        }

        if ($item->staff) {
            $item->staff = array_map(function ($member) use ($lang) {
                return [
                    'photo' => $member['photo'],
                    'name' => $member["name_{$lang}"] ?? '',
                    'position' => $member["position_{$lang}"] ?? '',
                    'email' => $member["email"] ?? '',
                    'phone' => $member["phone"] ?? '',
                ];
            }, $item->staff);
        }

        $parent = $item->parent;
        $children = $item->children;
        dd($item->umkd_files);

        return view('pages.faculties.show', compact('item', 'parent', 'children'));
    }

    private function translateDirectoryNames(array $directories): array
    {
        $currentLocale = app()->getLocale();
        if ($currentLocale === 'ru') return $directories;

        $dictionary = [
            'бакалавриат' => [
                'en' => 'Bachelor program',
                'kz' => 'Бакалавриат'
            ],
            'интернатура' => [
                'en' => 'Internship program',
                'kz' => 'Интернатура'
            ],
            'резидентура' => [
                'en' => 'Residency program',
                'kz' => 'Резидентура'
            ],
            'магистратура' => [
                'en' => 'Magistracy',
                'kz' => 'Магистратура'
            ],
            'докторантура' => [
                'en' => 'Doctorate',
                'kz' => 'Докторантура'
            ],
            'силлабус' => [
                'en' => 'Syllabuses',
                'kz' => 'Силлабустар'
            ],
            'силлабусы' => [
                'en' => 'Syllabuses',
                'kz' => 'Силлабустар'
            ],
            'кис' => [
                'en' => 'CMD',
                'kz' => 'БӨҚ'
            ],
            'лекции' => [
                'en' => 'Lectures',
                'kz' => 'Дәрістер'
            ],
            'лк' => [
                'en' => 'Lectures',
                'kz' => 'Дәрістер'
            ],
            'лекция' => [
                'en' => 'Lectures',
                'kz' => 'Дәрістер'
            ],
            'сро' => [
                'en' => 'SIW',
                'kz' => 'БАӨЖ'
            ],
            'срс' => [
                'en' => 'SIW',
                'kz' => 'СӨЖ'
            ],
            'пз' => [
                'en' => 'PE',
                'kz' => 'ТС'
            ],
            'методички' => [
                'en' => 'Guidelines',
                'kz' => 'Әдістемелік нұсқаулар'
            ],
            'рп' => [
                'en' => 'Work programs',
                'kz' => 'Жұмыс бағдарламалары'
            ],
            // Добавляйте другие базовые названия
        ];

        array_walk($directories, function (&$directory) use ($currentLocale, $dictionary) {
            // Разделяем название и год/дополнительную информацию
            preg_match('/(.*?)(\s*\d{4}-\d{4})?$/u', $directory['directory_name'], $matches);

            $baseName = mb_strtolower(trim($matches[1]));
            $yearPart = $matches[2] ?? '';

            // Ищем перевод базового названия
            $translatedBase = $dictionary[$baseName][$currentLocale] ?? $matches[1];

            // Собираем итоговое название
            $directory['directory_name'] = $translatedBase . $yearPart;

            // Обрабатываем поддиректории рекурсивно
            if (!empty($directory['subdirectories'])) {
                $directory['subdirectories'] = $this->translateDirectoryNames(
                    $directory['subdirectories']
                );
            }
        });

        return $directories;
    }
}
