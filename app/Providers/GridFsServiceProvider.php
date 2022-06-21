<?php

namespace App\Providers;

use App;
use App\Modules\RomFilesHandler;
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
        App::singleton(RomFilesHandler::class,
            fn() => new RomFilesHandler(databaseName: Config::get($key)));
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


    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [RomFilesHandler::class];
    }
}
