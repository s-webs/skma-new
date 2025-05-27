<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Theme;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menus = Menu::query()->whereNull('parent_id')->with('children')->orderBy('sort_order', 'asc')->get();
        $activeTheme = Theme::getActive();


        view()->composer('*', function ($view) {
        });

        view()->share('activeTheme', $activeTheme);
        view()->share('menus', $menus);
    }
}
