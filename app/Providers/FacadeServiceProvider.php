<?php

namespace App\Providers;

use App\Facades\RomRepositoryFacade;
use App\Repositories\GameRepository;
use App\Repositories\RomRepository;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RomRepository::class, fn() => new RomRepository);
        $this->app->bind(GameRepository::class, fn() => new GameRepository);
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

    public function provides()
    {
        return [RomRepository::class, GameRepository::class];
    }
}
