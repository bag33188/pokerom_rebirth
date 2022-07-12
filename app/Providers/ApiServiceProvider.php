<?php

namespace App\Providers;

use App\Interfaces\Service\GameServiceInterface as IGameApiService;
use App\Interfaces\Service\RomServiceInterface as IRomApiService;
use App\Interfaces\Service\RomFileServiceInterface as IRomFileApiService;
use App\Interfaces\Service\UserServiceInterface as IUserApiService;
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
        $this->app->bind(IUserApiService::class, UserService::class);
        $this->app->bind(IGameApiService::class, GameService::class);
        $this->app->bind(IRomApiService::class, RomService::class);
        $this->app->bind(IRomFileApiService::class, RomFileService::class);
    }
}
