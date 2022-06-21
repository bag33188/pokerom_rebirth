<?php

namespace App\Providers;

use App\Interfaces\FileServiceInterface as IFileDataService;
use App\Interfaces\GameServiceInterface as IGameDataService;
use App\Interfaces\RomServiceInterface as IRomDataService;
use App\Interfaces\UserServiceInterface as IUserDataService;
use App\Services\FileDataService;
use App\Services\GameDataService;
use App\Services\RomDataService;
use App\Services\UserDataService;
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
        $this->app->bind(IUserDataService::class, UserDataService::class);
        $this->app->bind(IGameDataService::class, GameDataService::class);
        $this->app->bind(IRomDataService::class, RomDataService::class);
        $this->app->bind(IFileDataService::class, FileDataService::class);
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
