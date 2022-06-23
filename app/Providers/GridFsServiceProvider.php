<?php

namespace App\Providers;

use App\Services\GridFS\RomFilesBucket;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use RomFile;

class GridFsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(RomFilesBucket::class,
            fn(Application $app): RomFilesBucket => new RomFilesBucket());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $dbProps = [
            config('gridfs.bucketName'),
            config('gridfs.chunkSize'),
            config('gridfs.connection.database')
        ];
        RomFile::setDatabaseValues(...$dbProps);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [RomFilesBucket::class];
    }
}
