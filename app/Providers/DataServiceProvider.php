<?php

namespace App\Providers;

use App\Interfaces\RomFileDataServiceInterface as IFileDataService;
use App\Interfaces\GameDataServiceInterface as IGameDataService;
use App\Interfaces\RomDataServiceInterface as IRomDataService;
use App\Interfaces\UserDataServiceInterface as IUserDataService;
use App\Services\Data\RomFileDataService;
use App\Services\Data\GameDataService;
use App\Services\Data\RomDataService;
use App\Services\Data\UserDataService;
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
        $this->app->bind(IFileDataService::class, RomFileDataService::class);
    }
}
