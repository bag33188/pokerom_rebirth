<?php

namespace App\Providers;

use App\Services\GridFS\RomFilesConnection;
use App\Services\GridFS\RomFilesDatabase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class GridFsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //! use scoped singleton since only admin user will be invoking this logic
        $this->app->scoped(RomFilesConnection::class, function (Application $app) {
            return new RomFilesConnection($app->make(RomFilesDatabase::class));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * _Does not bootstrap until service provider is needed._
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [RomFilesConnection::class];
    }
}
