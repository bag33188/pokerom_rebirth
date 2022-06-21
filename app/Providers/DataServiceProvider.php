<?php

namespace App\Providers;

use App\Interfaces\FileServiceInterface;
use App\Interfaces\GameServiceInterface;
use App\Interfaces\RomServiceInterface;
use App\Interfaces\UserServiceInterface;
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
        $this->app->bind(UserServiceInterface::class, UserDataService::class);
        $this->app->bind(GameServiceInterface::class, GameDataService::class);
        $this->app->bind(RomServiceInterface::class, RomDataService::class);
        $this->app->bind(FileServiceInterface::class, FileDataService::class);
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
