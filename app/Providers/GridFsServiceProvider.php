<?php

namespace App\Providers;

use App\Modules\FileHandler;
use Illuminate\Support\ServiceProvider;

class GridFsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileHandler::class, fn() => new FileHandler());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->register();
    }


    public function provides()
    {
        return [FileHandler::class];
    }
}
