<?php

namespace App\Providers;

use App\Actions\RomActions;
use App\Actions\RomFileActions;
use App\Actions\UserActions;
use App\Interfaces\RomActionsInterface;
use App\Interfaces\RomFileActionsInterface;
use App\Interfaces\UserActionsInterface;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RomActionsInterface::class, RomActions::class);
        $this->app->bind(UserActionsInterface::class, UserActions::class);
        $this->app->bind(RomFileActionsInterface::class, RomFileActions::class);
    }
}
