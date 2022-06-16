<?php

namespace App\Providers;

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
        $this->app->bind(UserService::class, User::class);
        $this->app->bind(RomService::class, Rom::class);
        $this->app->bind(GameService::class, Game::class);
        $this->app->bind(FileService::class, File::class);
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
