<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public readonly bool $ideHelperActive;
    protected bool $isLocal = true;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        if (!$this->app->isLocal()) $this->isLocal = false;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->isLocal) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->isLocal) {
            $this->ideHelperActive = true;
        }
    }
}
