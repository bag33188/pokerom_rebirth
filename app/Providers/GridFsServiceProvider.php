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
    public function register(): void
    {
        $this->app->bind(FileHandler::class, fn() => new FileHandler(config('database.connections.mongodb.database')));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->register();
    }


    public function provides(): array
    {
        return [FileHandler::class];
    }
}
