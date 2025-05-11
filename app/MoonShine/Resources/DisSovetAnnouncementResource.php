<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\DisSovetAnnouncement;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<DisSovetAnnouncement>
 */
class DisSovetAnnouncementResource extends ModelResource
{
    protected string $model = DisSovetAnnouncement::class;

    protected string $title = 'DisSovetAnnouncements';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name_ru'),
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
                BelongsTo::make('Образовательная программа', 'educationProgram', 'name_ru', resource: EducationProgramResource::class),
                Divider::make(),
                Tabs::make([
                    Tab::make('RU', [
                        Text::make('Название', 'name_ru')->unescape(),
                        TinyMce::make('Контент', 'description_ru'),
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название', 'name_kz')->unescape(),
                        TinyMce::make('Контент', 'description_kz'),
                    ]),
                    Tab::make('EN', [
                        Text::make('Название', 'name_en')->unescape(),
                        TinyMce::make('Контент', 'description_en'),
                    ]),
                ]),
                Divider::make(),
                File::make('Файлы', 'files')
                    ->disk('public')
                    ->dir('uploads/dis-sovet/announcements')
                    ->keepOriginalFileName()
                    ->sortable()
                    ->multiple()
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
     * @param DisSovetAnnouncement $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
