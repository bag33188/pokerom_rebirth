<?php

namespace App\Providers;

use App\Actions\GameActions;
use App\Actions\RomActions;
use App\Actions\RomFileActions;
use App\Actions\UserActions;
use App\Interfaces\Action\GameActionsInterface;
use App\Interfaces\Action\RomActionsInterface;
use App\Interfaces\Action\RomFileActionsInterface;
use App\Interfaces\Action\UserActionsInterface;
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
        $this->app->bind(GameActionsInterface::class, GameActions::class);
        $this->app->bind(UserActionsInterface::class, UserActions::class);
        $this->app->bind(RomFileActionsInterface::class, RomFileActions::class);
    }
}
