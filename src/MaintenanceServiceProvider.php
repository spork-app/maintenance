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

        Spork::addFeature('Garage', 'TruckIcon', '/maintenance/garage', 'crud');
        Spork::addFeature('Properties', 'HomeIcon', '/maintenance/properties', 'crud');
    }
}
