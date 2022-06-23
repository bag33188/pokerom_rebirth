<?php

namespace App\Providers;

use App;
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
        App::singleton(RomFilesBucket::class,
            fn(Application $app): RomFilesBucket => new RomFilesBucket());
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
