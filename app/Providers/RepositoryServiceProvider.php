<?php

namespace App\Providers;

use App\Interfaces\FileRepositoryInterface;
use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\RomRepositoryInterface;
use App\Repositories\FileRepository;
use App\Repositories\GameRepository;
use App\Repositories\RomRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
        $this->app->bind(RomRepositoryInterface::class, RomRepository::class);
        $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
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
