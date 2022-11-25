<?php

namespace Spork\Maintenance;

use Illuminate\Support\ServiceProvider;
use Spork\Core\Spork;

class MaintenanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->mergeConfigFrom(__DIR__ . '/../config/spork.php', 'spork.maintenance');
        Spork::addFeature('Maintenance', 'HomeIcon', '/maintenance', 'crud', ['garage', 'properties']);
    }
}
