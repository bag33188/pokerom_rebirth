<?php

namespace App\Providers;

use App\Jobs\UploadRomFile;
use App\Services\GridFS\RomFilesBucket;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Utils\Modules\GridFS\Connection;

class GridFsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {

        // use scoped singleton since only admin user will be invoking this logic
        $this->app->scoped(Connection::class, function (Application $app) {
            $dbProps = [
                config('gridfs.connection.database'),
                config('gridfs.bucketName'),
                config('gridfs.chunkSize'),
            ];
            return new Connection(...$dbProps);
        });
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
        return [Connection::class];
    }
}
