<?php

namespace App\Providers;

use App\Interfaces\Service\GameServiceInterface;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Interfaces\Service\RomServiceInterface;
use App\Interfaces\Service\UserServiceInterface;
use App\Services\Resources\GameService;
use App\Services\Resources\RomFileService;
use App\Services\Resources\RomService;
use App\Services\Resources\UserService;
use Illuminate\Support\ServiceProvider;


class ResourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(GameServiceInterface::class, GameService::class);
        $this->app->bind(RomServiceInterface::class, RomService::class);
        $this->app->bind(RomFileServiceInterface::class, RomFileService::class);
    }
}
