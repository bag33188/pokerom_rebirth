<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    private const USE_IDE_HELPER = false;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (self::USE_IDE_HELPER === true) {
            if (\App::isLocal()) {
                \App::register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view_name = str_replace('.', '-', $view->getName());
            View::share('view_name', $view_name);
        });
    }
}
