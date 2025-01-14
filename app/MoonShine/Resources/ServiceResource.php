<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Service>
 */
class ServiceResource extends ModelResource
{
    protected string $model = Service::class;

    protected string $title = 'Services';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name_ru')->sortable(),
            Image::make('Изображение', 'image_ru'),
            Number::make('Позиция', 'order')->sortable(),
            Switcher::make('Активно', 'active')
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
                    Tabs\Tab::make('RU', [
                        Text::make('Название на русском', 'name_ru')->required(),
                        Text::make('Ссылка на русском', 'link_ru')->required(),
                        Image::make('Изображение на русском', 'image_ru')
                            ->dir('uploads/services/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'service_' . $timestamp . "_ru_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tabs\Tab::make('KZ', [
                        Text::make('Название на казахском', 'name_kz')->required(),
                        Text::make('Ссылка на казахском', 'link_kz')->required(),
                        Image::make('Изображение на казахском', 'image_kz')
                            ->dir('uploads/services/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'service_' . $timestamp . "_kz_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                    Tabs\Tab::make('EN', [
                        Text::make('Название на английском', 'name_en')->required(),
                        Text::make('Ссылка на английском', 'link_en')->required(),
                        Image::make('Изображение на английском', 'image_en')
                            ->dir('uploads/services/')
                            ->customName(function ($file, $field) {
                                $timestamp = now()->format('Y_m_d_His');
                                return 'service_' . $timestamp . "_en_." . $file->extension();
                            })
                            ->removable(),
                    ]),
                ]),
                Divider::make(),
                Number::make('Позиция', 'order')->default(1),
                Switcher::make('Активно', 'active')->default(true),
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
     * @param Service $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
