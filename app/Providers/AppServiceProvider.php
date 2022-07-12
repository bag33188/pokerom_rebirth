<?php

namespace App\Providers;

use App;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (App::isLocal()) {
            App::register(IdeHelperServiceProvider::class);
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
