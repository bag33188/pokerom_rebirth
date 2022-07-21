<?php

namespace App\Providers;

use App\Interfaces\Service\GameServiceInterface as IGameObjectService;
use App\Interfaces\Service\RomFileServiceInterface as IRomFileObjectService;
use App\Interfaces\Service\RomServiceInterface as IRomObjectService;
use App\Interfaces\Service\UserServiceInterface as IUserObjectService;
use App\Services\Objects\GameService as GameObjectService;
use App\Services\Objects\RomFileService as RomFileObjectService;
use App\Services\Objects\RomService as RomObjectService;
use App\Services\Objects\UserService as UserObjectService;
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
        $this->app->bind(IUserObjectService::class, UserObjectService::class);
        $this->app->bind(IGameObjectService::class, GameObjectService::class);
        $this->app->bind(IRomObjectService::class, RomObjectService::class);
        $this->app->bind(IRomFileObjectService::class, RomFileObjectService::class);
    }
}
