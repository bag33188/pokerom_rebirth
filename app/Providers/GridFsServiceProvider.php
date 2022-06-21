<?php

namespace App\Providers;

use App;
use App\Modules\RomFilesHandler;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class GridFsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    private const DB_NAME_CONF_KEY = 'database.connections.mongodb.database';

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $databaseName = Config::get(self::DB_NAME_CONF_KEY);
        App::singleton(RomFilesHandler::class,
            fn() => new RomFilesHandler($databaseName));
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
     * Defer Service until needed.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [RomFilesHandler::class];
    }
}
