<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\DisSovetDocument;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<DisSovetDocument>
 */
class DisSovetDocumentResource extends ModelResource
{
    protected string $model = DisSovetDocument::class;

    protected string $title = 'DisSovetDocuments';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название документа RU', 'title_ru'),
            Text::make('Название документа KZ', 'title_kz'),
            Text::make('Название документа EN', 'title_en'),
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
                        Text::make('Название документа', 'title_ru')->unescape(),
                        File::make('Файл', 'file_ru')
                            ->dir('uploads/dis-sovet/documents')
                    ]),
                    Tab::make('KZ', [
                        Text::make('Название документа', 'title_kz')->unescape(),
                        File::make('Файл', 'file_kz')
                            ->dir('uploads/dis-sovet/documents')
                    ]),
                    Tab::make('EN', [
                        Text::make('Название документа', 'title_en')->unescape(),
                        File::make('Файл', 'file_en')
                            ->dir('uploads/dis-sovet/documents')
                    ]),
                ])
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
     * @param DisSovetDocument $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
