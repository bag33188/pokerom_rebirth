<?php

namespace App\Providers;

use App\Interfaces\FileServiceInterface;
use App\Interfaces\GameServiceInterface;
use App\Interfaces\RomServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use App\Services\GameService;
use App\Services\RomService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(GameServiceInterface::class, GameService::class);
        $this->app->bind(RomServiceInterface::class, RomService::class);
        $this->app->bind(FileServiceInterface::class, FileService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->register();
    }
}
