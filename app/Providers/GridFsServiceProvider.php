<?php

namespace App\Providers;

use App\Services\GridFS\RomFilesBucket;
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
        $dbProps = array(
            config('gridfs.connection.database'),
            config('gridfs.bucketName'),
            config('gridfs.chunkSize'),
        );
        // use singleton since only admin user will be invoking this logic
        $this->app->singleton(RomFilesBucket::class,
            fn(Application $app): RomFilesBucket => new RomFilesBucket(...$dbProps));
    }

    /**
     * Get the services provided by the provider.
     *
     * _Does not bootstrap until service provider is needed_.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [RomFilesBucket::class];
    }
}
