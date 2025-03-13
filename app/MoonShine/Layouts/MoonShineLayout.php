<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\CompactLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When
};
use App\MoonShine\Resources\CounterResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\MenuResource;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Resources\NewsResource;
use App\MoonShine\Resources\OrgNodeResource;
use App\MoonShine\Resources\RolesResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\AnnounceResource;
use App\MoonShine\Resources\FeedbackResource;
use App\MoonShine\Resources\AdvertResource;
use App\MoonShine\Resources\GalleryResource;
use App\MoonShine\Resources\AwardResource;
use App\MoonShine\Resources\PartnerResource;
use App\MoonShine\Resources\DepartmentResource;
use App\MoonShine\Resources\DivisionResource;
use App\MoonShine\Resources\FacultyResource;
use App\MoonShine\Resources\ThemeResource;

final class MoonShineLayout extends CompactLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuGroup::make('Об академии', [
                MenuItem::make('Счетчики', CounterResource::class, 'variable'),
//                MenuItem::make('Структура правления', OrgNodeResource::class, 'share'),
                MenuItem::make('Сервисы', ServiceResource::class),
                MenuItem::make('Меню', MenuResource::class),
                MenuItem::make('Галерея', GalleryResource::class),
                MenuItem::make('Награды и достижения', AwardResource::class),
                MenuItem::make('Партнеры', PartnerResource::class),
            ], 'building-library'),
            MenuGroup::make('Структура', [
                MenuItem::make('Подразделения', DivisionResource::class),
            ], 'bars-3-bottom-left'),
            MenuGroup::make('Учебный процесс', [
                MenuItem::make('Факультеты', FacultyResource::class),
                MenuItem::make('Кафедры', DepartmentResource::class),
            ], 'academic-cap'),
            MenuGroup::make('Пресса', [
                MenuItem::make('Анонсы', AnnounceResource::class),
                MenuItem::make('Новости', NewsResource::class),
                MenuItem::make('Отзывы студентов', FeedbackResource::class),
                MenuItem::make('Объявления', AdvertResource::class),
            ], 'newspaper'),
            MenuGroup::make('Пользователи сайта', [
                MenuItem::make('Users', UserResource::class),
                MenuItem::make('Roles', RolesResource::class),
            ], 'users'),
            MenuGroup::make('Настройки', [
                MenuItem::make('Темы', ThemeResource::class),
            ], 'wrench-screwdriver'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
