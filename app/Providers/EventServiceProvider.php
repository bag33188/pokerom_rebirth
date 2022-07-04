<?php

namespace App\Providers;

use App\Events\RomFileDeleted;
use App\Events\RomFileUploaded;
use App\Events\GameCreated;
use App\Listeners\AssociateRomWithGame;
use App\Listeners\UnsetRomFileData;
use App\Listeners\UpdateMatchingRom;
use App\Models\Game;
use App\Models\Rom;
use App\Models\User;
use App\Observers\GameObserver;
use App\Observers\RomObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RomFileDeleted::class => [
            UnsetRomFileData::class
        ],
        RomFileUploaded::class => [
            UpdateMatchingRom::class
        ],
        GameCreated::class => [
            AssociateRomWithGame::class
        ]
    ];

    protected $observers = [
        Game::class => [GameObserver::class],
        Rom::class => [RomObserver::class],
        User::class => [UserObserver::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->register();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
