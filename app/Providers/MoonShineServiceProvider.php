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
            ])
            ->pages([
                ...$config->getPages(),
                MenuIndexPage::class,
                OrgNodeIndexPage::class,
            ]);
    }
}
