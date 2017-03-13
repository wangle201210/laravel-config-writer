<?php

namespace Infinety\Config;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        // Bind it only once so we can reuse in IoC
        $this->app->singleton('Infinety\Config\Repository', function ($app, $items) {
            $writer = new FileWriter($app['files'], $app['path.config']);

            return new Repository($items, $writer);
        });

        // Capture the loaded configuration items
        $config_items = app('config')->all();

        $config_items = $this->app->singleton('Infinety\Config\Repository', function ($app) use ($config_items) {
            return $app->make('Infinety\Config\Repository', $config_items);
        });
    }
}
