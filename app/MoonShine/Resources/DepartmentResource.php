<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Fields\Fmanager;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

use Illuminate\Database\Query\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\PageType;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Text;
use Sweet1s\MoonshineFileManager\FileManager;
use Sweet1s\MoonshineFileManager\FileManagerTypeEnum;

/**
 * @extends ModelResource<Department>
 */
class DepartmentResource extends ModelResource
{
    protected string $model = Department::class;

    protected string $title = 'Кафедры';

    protected string $sortColumn = 'name_ru';

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Превью', 'preview'),
            Text::make('Название', 'name_ru'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                BelongsTo::make('Факультет', 'parent', 'name_ru', FacultyResource::class)
                    ->nullable(),
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название', 'name_ru'),
                        TinyMce::make('Описание', 'description_ru'),
                        Json::make('Контакты', 'contacts_ru')
                            ->fields([
                                Position::make(),
                                Text::make('Ключ на русском', 'key'),
                                Text::make('Значение на русском', 'value')
                            ])
                            ->removable(),
                        Slug::make('Slug', 'slug_ru')->from('name_ru')
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'name_kz'),
                        TinyMce::make('Описание', 'description_kz'),
                        Json::make('Контакты', 'contacts_kz')
                            ->fields([
                                Position::make(),
                                Text::make('Ключ на казахском', 'key'),
                                Text::make('Значение на казахском', 'value')
                            ])
                            ->removable(),
                        Slug::make('Slug', 'slug_kz')->from('name_kz')
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'name_en'),
                        TinyMce::make('Описание', 'description_en'),
                        Json::make('Контакты', 'contacts_en')
                            ->fields([
                                Position::make(),
                                Text::make('Ключ на английском', 'key'),
                                Text::make('Значение на английском', 'value')
                            ])
                            ->removable(),
                        Slug::make('Slug', 'slug_en')->from('name_en')
                    ]),
                    Tab::make('Сотрудники', [
                        Json::make('Состав', 'staff')
                            ->fields([
                                Position::make(),
                                Image::make('Фотография', 'photo')
                                    ->dir('uploads/departments/staff')
                                    ->customName(function ($file, $field) {
                                        $timestamp = now()->format('Y_m_d_His');
                                        return 'staff_' . $timestamp . "_RU_." . $file->extension();
                                    })
                                    ->removable(),
                                Text::make('Имя на русском', 'name_ru'),
                                Text::make('Должность на русском', 'position_ru'),
                                Text::make('Имя на казахском', 'name_kz'),
                                Text::make('Должность на казахском', 'position_kz'),
                                Text::make('Имя на английском', 'name_en'),
                                Text::make('Должность на английском', 'position_en'),
                            ])
                            ->vertical()
                            ->removable(),
                    ]),
                    Tab::make('УМКД', [
                        Json::make('УМКД', 'umkd')
                            ->fields([
                                Position::make(),
                                Text::make('Тип документов на русском', 'type_ru'),
                                Text::make('Тип документов на казахском', 'type_kz'),
                                Text::make('Тип документов на английском', 'type_en'),
                                Fmanager::make('files'),
//                                FileManager::make('УМКД', 'files')
//                                    ->typeOfFileManager(FileManagerTypeEnum::File)
//                                    ->removable()
//                                    ->onApply(function ($item, $value, $field) {
//                                        $request = request()->all();
//
//                                        // Проверяем, есть ли файлы
//                                        if (!isset($request['files']) || empty($request['files'])) {
//                                            return $item;
//                                        }
//
//                                        $filesString = $request['files'];
//
//                                        // Разделяем строку на массив файлов
//                                        $filesArray = preg_split('/,(?=https?:\/\/)/', $filesString);
//
//                                        // Обрабатываем файлы: удаляем домен, получаем имя файла и расширение
//                                        $processedFiles = array_map(function ($file) {
//                                            $path = parse_url($file, PHP_URL_PATH); // Получаем путь без домена
//                                            $cleanPath = ltrim($path, '/'); // Убираем начальный слеш
//                                            $filename = basename($path); // Получаем имя файла
//
//                                            // Получаем информацию о файле: имя и расширение
//                                            $fileInfo = pathinfo($filename);
//                                            $filenameWithoutExtension = $fileInfo['filename']; // Имя файла без расширения
//                                            $extension = isset($fileInfo['extension']) ? $fileInfo['extension'] : ''; // Расширение файла
//
//                                            return [
//                                                'path' => $cleanPath, // Путь без домена
//                                                'filename' => $filenameWithoutExtension, // Имя файла без расширения
//                                                'ext' => $extension, // Расширение файла
//                                            ];
//                                        }, $filesArray);
//
//                                        // Добавляем обработанные файлы в объект
//                                        $umkdFiles = ['files' => $processedFiles];
//                                        $item += $umkdFiles;
//
//                                        return $item;
//                                    })
                            ])
                            ->vertical()
                            ->removable(),
                    ]),
                ]),
                Divider::make(),
                Image::make('Превью', 'preview')
                    ->dir('uploads/departments/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'department_' . $timestamp . "_." . $file->extension();
                    })
                    ->removable(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param Department $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
