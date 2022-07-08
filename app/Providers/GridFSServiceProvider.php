<?php

namespace App\Providers;

use App\Jobs\ProcessRomFileDeletion;
use App\Jobs\ProcessRomFileDownload;
use App\Jobs\ProcessRomFileUpload;
use App\Services\GridFS\RomFileProcessor;
use App\Services\GridFS\RomFilesConnection;
use App\Services\GridFS\RomFilesDatabase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class GridFSServiceProvider extends ServiceProvider implements DeferrableProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bindMethod([ProcessRomFileDownload::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(RomFileProcessor::class));
        });
        $this->app->bindMethod([ProcessRomFileUpload::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(RomFileProcessor::class));
        });
        $this->app->bindMethod([ProcessRomFileDeletion::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(RomFileProcessor::class));
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
