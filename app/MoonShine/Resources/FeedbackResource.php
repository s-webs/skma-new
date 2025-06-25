<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Feedback>
 */
class FeedbackResource extends ModelResource
{
    protected string $model = Feedback::class;

    protected string $title = 'Feedback';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Фотография', 'image'),
            Select::make('Язык', 'language')
                ->options([
                    'ru' => 'Русский',
                    'kz' => 'Казахский',
                    'en' => 'Английский',
                ])->badge(),
            Text::make('Имя', 'name'),
            Text::make('О студенте', 'about'),
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
                Select::make('Язык', 'language')
                    ->options([
                        'ru' => 'Русский',
                        'kz' => 'Казахский',
                        'en' => 'Английский',
                    ]),
                Image::make('Фотография', 'image')
                    ->dir('uploads/feedback/')
                    ->customName(function ($file, $field) {
                        $timestamp = now()->format('Y_m_d_His');
                        return 'feedback_' . $timestamp . "_." . $file->extension();
                    })
                    ->removable(),
                Text::make('Имя', 'name')->unescape(),
                Text::make('О студенте', 'about')->unescape(),
                Textarea::make('Отзыв', 'message'),
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
     * @param Feedback $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
