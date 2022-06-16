<?php

namespace App\Providers;

use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Listeners\UpdateMatchingRom;
use App\Listeners\UnsetRomFileData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Rom;
use App\Models\User;
use App\Observers\GameObserver;
use App\Observers\RomObserver;
use App\Observers\UserObserver;
use App\Models\Game;

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
        FileDeleted::class => [
            UnsetRomFileData::class
        ],
        FileUploaded::class => [
            UpdateMatchingRom::class
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
