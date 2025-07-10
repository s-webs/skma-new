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
use App\MoonShine\Resources\ForStudentResource;
use App\MoonShine\Resources\UmkdResource;
use App\MoonShine\Resources\KomplaensResource;
use App\MoonShine\Resources\GraduateResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\EducationProgramResource;
use App\MoonShine\Resources\DisSovetDocumentResource;
use App\MoonShine\Resources\DisSovetReportResource;
use App\MoonShine\Resources\DisSovetInformationResource;
use App\MoonShine\Resources\DisSovetStaffResource;
use App\MoonShine\Resources\DisSovetAnnouncementResource;
use App\MoonShine\Resources\CmsPageResource;
use App\MoonShine\Resources\ForApplicantResource;

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
        $userRoleId = request()->user('moonshine')->moonshine_user_role_id;

        $menu = [];

        if ($userRoleId === 1) {
            $menu = [
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
                    MenuItem::make('Вкладки подразделений', PageResource::class),
                    MenuItem::make('Комплаенс служба', KomplaensResource::class),
                    MenuItem::make('Страницы', CmsPageResource::class),
                ], 'bars-3-bottom-left'),
                MenuGroup::make('Учебный процесс', [
                    MenuItem::make('Факультеты', FacultyResource::class),
                    MenuItem::make('Кафедры', DepartmentResource::class),
                    MenuItem::make('Для абитуриентов', ForApplicantResource::class),
                    MenuItem::make('Для студентов', ForStudentResource::class),
                    MenuItem::make('Выпускникам', GraduateResource::class),
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
                    MenuItem::make('Файловый менеджер', route('fmanager.index')),
                    MenuItem::make('CmsPages', CmsPageResource::class),
                ], 'wrench-screwdriver'),
                MenuGroup::make('Дисс совет', [
                    MenuItem::make('Образовательные программы', EducationProgramResource::class),
                    MenuItem::make('Документы диссертационного совета', DisSovetDocumentResource::class),
                    MenuItem::make('Отчеты диссертационного совета', DisSovetReportResource::class),
                    MenuItem::make('Информация для претендентов', DisSovetInformationResource::class),
                    MenuItem::make('Состав диссертационного совета', DisSovetStaffResource::class),
                    MenuItem::make('Объявления о защитах', DisSovetAnnouncementResource::class),
                ]),
        ];
        } elseif ($userRoleId === 2) {
            $menu = [
                MenuGroup::make('Об академии', [
                    MenuItem::make('Счетчики', CounterResource::class, 'variable'),
                    MenuItem::make('Сервисы', ServiceResource::class),
                    MenuItem::make('Меню', MenuResource::class),
                    MenuItem::make('Галерея', GalleryResource::class),
                    MenuItem::make('Награды и достижения', AwardResource::class),
                    MenuItem::make('Партнеры', PartnerResource::class),
                ], 'building-library'),
                MenuGroup::make('Структура', [
                    MenuItem::make('Подразделения', DivisionResource::class),
                    MenuItem::make('Вкладки подразделений', PageResource::class),
                    MenuItem::make('Комплаенс служба', KomplaensResource::class),
                    MenuItem::make('Страницы', CmsPageResource::class),
                ], 'bars-3-bottom-left'),
                MenuGroup::make('Учебный процесс', [
                    MenuItem::make('Факультеты', FacultyResource::class),
                    MenuItem::make('Кафедры', DepartmentResource::class),
                    MenuItem::make('Для абитуриентов', ForApplicantResource::class),
                    MenuItem::make('Для студентов', ForStudentResource::class),
                    MenuItem::make('Выпускникам', GraduateResource::class),
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
                    MenuItem::make('Файловый менеджер', route('fmanager.index'))
                ], 'wrench-screwdriver'),
                MenuGroup::make('Дисс совет', [
                    MenuItem::make('Образовательные программы', EducationProgramResource::class),
                    MenuItem::make('Документы диссертационного совета', DisSovetDocumentResource::class),
                    MenuItem::make('Отчеты диссертационного совета', DisSovetReportResource::class),
                    MenuItem::make('Информация для претендентов', DisSovetInformationResource::class),
                    MenuItem::make('Состав диссертационного совета', DisSovetStaffResource::class),
                    MenuItem::make('Объявления о защитах', DisSovetAnnouncementResource::class),
                ]),
            ];
        } elseif ($userRoleId === 3) {
            $menu = [
                MenuItem::make('Анонсы', AnnounceResource::class),
                MenuItem::make('Новости', NewsResource::class),
                MenuItem::make('Подразделения', DivisionResource::class),
                MenuItem::make('Факультеты', FacultyResource::class),
                MenuItem::make('Кафедры', DepartmentResource::class),
            ];
        } else {
            return $menu;
        }

        return $menu;
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
