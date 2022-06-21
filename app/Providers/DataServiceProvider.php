<?php

namespace App\Providers;

use App\Interfaces\FileDataServiceInterface as IFileDataService;
use App\Interfaces\GameDataServiceInterface as IGameDataService;
use App\Interfaces\RomDataServiceInterface as IRomDataService;
use App\Interfaces\UserDataServiceInterface as IUserDataService;
use App\Services\FileDataDataService;
use App\Services\GameDataDataService;
use App\Services\RomDataDataService;
use App\Services\UserDataDataService;
use Illuminate\Support\ServiceProvider;


class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(IUserDataService::class, UserDataDataService::class);
        $this->app->bind(IGameDataService::class, GameDataDataService::class);
        $this->app->bind(IRomDataService::class, RomDataDataService::class);
        $this->app->bind(IFileDataService::class, FileDataDataService::class);
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
}
