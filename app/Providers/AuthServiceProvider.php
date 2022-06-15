<?php

namespace App\Providers;

use App\Models\{File, Game, Rom, User};
use App\Policies\{FilePolicy, GamePolicy, RomPolicy, UserPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Game::class => GamePolicy::class,
        Rom::class => RomPolicy::class,
        File::class => FilePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // keep these as gates since multiple api controllers will need to use them
        Gate::define('viewAny-user', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('viewAny-file', function (User $user) {
            return $user->isAdmin();
        });

        // give admin user complete access to all endpoints and actions
        Gate::before(function (User $user, string $ability) {
            # dd($ability); ddd($ability);
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
