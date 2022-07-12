<?php

namespace App\Providers;

use App\Interfaces\Service\GameServiceInterface as IGameDataService;
use App\Interfaces\Service\RomServiceInterface as IRomDataService;
use App\Interfaces\Service\RomFileServiceInterface as IRomFileDataService;
use App\Interfaces\Service\UserServiceInterface as IUserDataService;
use App\Services\Api\GameService;
use App\Services\Api\RomService;
use App\Services\Api\RomFileService;
use App\Services\Api\UserService;
use Illuminate\Support\ServiceProvider;


class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(IUserDataService::class, UserService::class);
        $this->app->bind(IGameDataService::class, GameService::class);
        $this->app->bind(IRomDataService::class, RomService::class);
        $this->app->bind(IRomFileDataService::class, RomFileService::class);
    }
}
