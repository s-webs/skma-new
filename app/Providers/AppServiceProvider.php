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
        view()->composer('*', function ($view) {
            $menus = Menu::query()->whereNull('parent_id')->with('children')->orderBy('sort_order', 'asc')->get();
            $view->with('menus', $menus);

            // Получаем активную тему
            $activeTheme = Theme::query()->where('active', true)->first();
            $view->with('activeTheme', $activeTheme);
        });
    }
}
