<?php

namespace App\Providers;

use App\Interfaces\Service\GameServiceInterface;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Interfaces\Service\RomServiceInterface;
use App\Interfaces\Service\UserServiceInterface;
use App\Services\Object\GameService;
use App\Services\Object\RomFileService;
use App\Services\Object\RomService;
use App\Services\Object\UserService;
use Illuminate\Support\ServiceProvider;


class ObjectServiceProvider extends ServiceProvider
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
