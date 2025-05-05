<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\CounterResource;
use App\MoonShine\Resources\MenuResource;
use App\MoonShine\Pages\MenuIndexPage;
use App\MoonShine\Resources\ServiceResource;
use App\MoonShine\Resources\NewsResource;
use App\MoonShine\Resources\OrgNodeResource;
use App\MoonShine\Pages\OrgNodeIndexPage;
use App\MoonShine\Resources\RolesResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\AnnounceResource;
use App\MoonShine\Resources\FeedbackResource;
use App\MoonShine\Resources\AdvertResource;
use App\MoonShine\Resources\GalleryResource;
use App\MoonShine\Resources\AwardResource;
use App\MoonShine\Pages\AwardIndexPage;
use App\MoonShine\Resources\PartnerResource;
use App\MoonShine\Resources\DepartmentResource;
use App\MoonShine\Resources\DivisionResource;
use App\MoonShine\Resources\FacultyResource;
use App\MoonShine\Pages\DivisionsIndexPage;
use App\MoonShine\Resources\ThemeResource;
use App\MoonShine\Resources\ForStudentResource;
use App\MoonShine\Resources\KomplaensResource;
use App\MoonShine\Resources\GraduateResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\EducationProgramResource;
use App\MoonShine\Resources\DisSovetDocumentResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param MoonShine $core
     * @param MoonShineConfigurator $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                CounterResource::class,
                MenuResource::class,
                ServiceResource::class,
                NewsResource::class,
                OrgNodeResource::class,
                RolesResource::class,
                UserResource::class,
                AnnounceResource::class,
                FeedbackResource::class,
                AdvertResource::class,
                GalleryResource::class,
                AwardResource::class,
                PartnerResource::class,
                DepartmentResource::class,
                DivisionResource::class,
                FacultyResource::class,
                ThemeResource::class,
                ForStudentResource::class,
                KomplaensResource::class,
                GraduateResource::class,
                PageResource::class,
                EducationProgramResource::class,
                DisSovetDocumentResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                MenuIndexPage::class,
                OrgNodeIndexPage::class,
                AwardIndexPage::class,
                DivisionsIndexPage::class,
            ]);
    }
}
