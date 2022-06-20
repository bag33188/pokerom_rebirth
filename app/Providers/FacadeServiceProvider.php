<?php

namespace App\Providers;

use App\Repositories\FileRepository;
use App\Repositories\GameRepository;
use App\Repositories\RomRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RomRepository::class, fn() => new RomRepository);
        $this->app->bind(GameRepository::class, fn() => new GameRepository);
        $this->app->bind(FileRepository::class, fn() => new FileRepository);
        $this->app->bind(UserRepository::class, fn() => new UserRepository);
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

    public function provides(): array
    {
        return [RomRepository::class, GameRepository::class, FileRepository::class, UserRepository::class];
    }
}
