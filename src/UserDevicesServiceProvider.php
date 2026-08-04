<?php

namespace Whilesmart\UserDevices;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserDevicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/user-devices.php', 'user-devices');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], ['laravel-user-devices', 'laravel-user-devices-migrations']);

        if (config('user-devices.register_routes', true)) {
            $prefix = config('user-devices.route_prefix', 'api');
            if ($prefix) {
                Route::prefix($prefix)->group(function () {
                    $this->loadRoutesFrom(__DIR__ . '/../routes/user-devices.php');
                });
            } else {
                $this->loadRoutesFrom(__DIR__ . '/../routes/user-devices.php');
            }
        }

        $this->publishes([
            __DIR__ . '/../routes/user-devices.php' => base_path('routes/user-devices.php'),
        ], ['laravel-user-devices', 'laravel-user-devices-routes', 'laravel-user-devices-controllers']);

        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], ['laravel-user-devices', 'laravel-user-devices-controllers']);

        $this->publishes([
            __DIR__ . '/Http/Interfaces' => app_path('Http/Interfaces'),
        ], ['laravel-user-devices', 'laravel-user-devices-docs']);

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang'),
        ], ['laravel-user-devices', 'laravel-user-devices-locals']);

        // Publish config
        $this->publishes([
            __DIR__ . '/../config/user-devices.php' => config_path('user-devices.php'),
        ], ['laravel-user-devices', 'laravel-user-devices-config']);
    }
}
