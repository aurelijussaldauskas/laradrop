<?php

namespace AurelijusSaldauskas\Laradrop;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LaradropServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'AurelijusSaldauskas\Laradrop\Events\FileWasDeleted' => [
            'AurelijusSaldauskas\Laradrop\Handlers\Events\DeleteFile',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @param DispatcherContract|null $events
     * @return void
     */
    public function boot(DispatcherContract $events = null)
    {
        // different constructor signature for 5.3+
        if (\App::version() >= '5.3.0') {
            parent::boot();
        } else {
            parent::boot($events);
        }

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('laradrop.php')
        ]);

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/aurelijussaldauskas/laradrop')
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laradrop');

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'laradrop');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
