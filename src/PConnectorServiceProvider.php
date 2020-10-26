<?php

namespace MedianetDev\PConnector;

use Illuminate\Support\ServiceProvider;

class PConnectorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'p-connector');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'p-connector');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole() && function_exists('config_path')) {  // function not available and 'publish' not relevant in Lumen
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('p-connector.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/p-connector'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/p-connector'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/p-connector'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'p-connector');

        // Register the main class to use with the facade
        $this->app->bind('p-connector', function () {
            $httpClient = config('p-connector.http_client');
            $httpClient = new $httpClient;

            return new PConnector($httpClient);
        });
    }
}
