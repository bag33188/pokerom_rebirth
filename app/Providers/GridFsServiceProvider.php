<?php

namespace App\Providers;

use App;
use App\Modules\FileHandler;
use Config;
use Illuminate\Support\ServiceProvider;

class GridFsServiceProvider extends ServiceProvider
{
    private const DB_NAME_CONF_KEY = 'database.connections.mongodb.database';

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $key = self::DB_NAME_CONF_KEY;
        App::bind(FileHandler::class,
            fn() => new FileHandler(Config::get($key)));
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
