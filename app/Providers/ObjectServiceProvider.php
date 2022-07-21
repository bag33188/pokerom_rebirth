<?php

namespace App\Providers;

use App\Interfaces\Service\GameServiceInterface as GameObjectServiceInterface;
use App\Interfaces\Service\RomFileServiceInterface as RomFileObjectServiceInterface;
use App\Interfaces\Service\RomServiceInterface as RomObjectServiceInterface;
use App\Interfaces\Service\UserServiceInterface as UserObjectServiceInterface;
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
        $this->app->bind(UserObjectServiceInterface::class, UserObjectService::class);
        $this->app->bind(GameObjectServiceInterface::class, GameObjectService::class);
        $this->app->bind(RomObjectServiceInterface::class, RomObjectService::class);
        $this->app->bind(RomFileObjectServiceInterface::class, RomFileObjectService::class);
    }
}
