<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\ForStudent;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Url;
use Sweet1s\MoonshineFileManager\FileManager;
use Sweet1s\MoonshineFileManager\FileManagerTypeEnum;

/**
 * @extends ModelResource<ForStudent>
 */
class ForStudentResource extends ModelResource
{
    protected string $model = ForStudent::class;

    protected string $title = 'Для студентов';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
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
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Заголовок', 'title_ru'),
                        Textarea::make('Описание', 'description_ru'),
                        Json::make('Карточки', 'cards_ru')
                            ->fields([
                                Position::make(),
                                Text::make('Название', 'title'),
                                Text::make('Подзаголовок', 'subtitle'),
                                Select::make('Опция', 'option')
                                    ->options([
                                        'link' => 'Ссылка',
                                        'file' => 'Файл',
                                    ]),
                                Text::make('Ссылка', 'link'),
                                File::make('Файл', 'file')
                                    ->dir('uploads/for-students/ru/')
                                    ->keepOriginalFileName()
                                    ->removable(),
                            ])
                            ->vertical()
                            ->removable(),
                        Text::make('Slug', 'slug_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Заголовок', 'title_kz'),
                        Textarea::make('Описание', 'description_kz'),
                        Json::make('Карточки', 'cards_kz')
                            ->fields([
                                Position::make(),
                                Text::make('Название', 'title'),
                                Text::make('Подзаголовок', 'subtitle'),
                                Select::make('Опция', 'option')
                                    ->options([
                                        'link' => 'Ссылка',
                                        'file' => 'Файл',
                                    ]),
                                Text::make('Ссылка', 'link'),
                                File::make('Файл', 'file')
                                    ->dir('uploads/for-students/kz/')
                                    ->keepOriginalFileName()
                                    ->removable(),
                            ])
                            ->vertical()
                            ->removable(),
                        Text::make('Slug', 'slug_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Заголовок', 'title_en'),
                        Textarea::make('Описание', 'description_en'),
                        Json::make('Карточки', 'cards_en')
                            ->fields([
                                Position::make(),
                                Text::make('Название', 'title'),
                                Text::make('Подзаголовок', 'subtitle'),
                                Select::make('Опция', 'option')
                                    ->options([
                                        'link' => 'Ссылка',
                                        'file' => 'Файл',
                                    ]),
                                Text::make('Ссылка', 'link'),
                                File::make('Файл', 'file')
                                    ->dir('uploads/for-students/en/')
                                    ->keepOriginalFileName()
                                    ->removable(),
                            ])
                            ->vertical()
                            ->removable(),
                        Text::make('Slug', 'slug_en'),
                    ]),
                    Tab::make('Документы', [
                        Text::make('Ссылка на элективные дисциплины RU', 'electiveCatalog_ru'),
                        Text::make('Ссылка на элективные дисциплины KZ', 'electiveCatalog_kz'),
                        Text::make('Ссылка на элективные дисциплины EN', 'electiveCatalog_en'),
                        Text::make('Ссылка на академические календари', 'academic_calendars'),
                        Collapse::make('Видео мaтериалы', [
                            Json::make('video_materials')
                                ->fields([
                                    Position::make(),
                                    Url::make('Внешняя ссылка URL', 'url_external'),
                                    Text::make('Ссылка на внутренние файлы', 'url_internal')
                                ])
                                ->removable()
                        ]),
                        Collapse::make('Расписание занятий', [
                            Json::make('Расписание занятий', 'schedule_lesson')
                                ->fields([
                                    Position::make(),
                                    Text::make('Название на русском', 'shedule_title_ru'),
                                    Text::make('Название на казахском', 'shedule_title_kz'),
                                    Text::make('Название на английском', 'shedule_title_en'),
                                    Text::make('Ссылка', 'link'),
                                ])
                                ->vertical()
                                ->removable(),
                        ]),
                        Collapse::make('Расписание экзаменов', [
                            Json::make('Расписание экзаменов', 'schedule_exam')
                                ->fields([
                                    Position::make(),
                                    Text::make('Название на русском', 'shedule_title_ru'),
                                    Text::make('Название на казахском', 'shedule_title_kz'),
                                    Text::make('Название на английском', 'shedule_title_en'),
                                    Text::make('Ссылка', 'link'),
                                ])
                                ->vertical()
                                ->removable(),
                        ]),
                    ])
                ]),
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
     * @param ForStudent $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
