<?php

namespace App\Providers;

use App\Interfaces\FileRepositoryInterface;
use App\Interfaces\RomRepositoryInterface;
use App\Repositories\FileRepository;
use App\Repositories\RomRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
        $this->app->bind(RomRepositoryInterface::class, RomRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
