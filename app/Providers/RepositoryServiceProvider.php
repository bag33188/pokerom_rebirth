<?php

namespace App\Providers;

use App\Factories\FileRepositoryFactory;
use App\Factories\GameRepositoryFactory;
use App\Factories\RomRepositoryFactory;
use App\Factories\UserRepositoryFactory;
use App\Repositories\FileRepository;
use App\Repositories\GameRepository;
use App\Repositories\RomRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(FileRepositoryFactory::class, FileRepository::class);
        $this->app->bind(RomRepositoryFactory::class, RomRepository::class);
        $this->app->bind(GameRepositoryFactory::class, GameRepository::class);
        $this->app->bind(UserRepositoryFactory::class, UserRepository::class);
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
