<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\FileHandler;

class GridFsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('filehandler', function () {
            new FileHandler();
        });
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
}
