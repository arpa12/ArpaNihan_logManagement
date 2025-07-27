<?php

namespace Arpanihan\LogManagement;

use Illuminate\Support\ServiceProvider;

class LogManagementServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/ActionLog/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/ActivityLog/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/ActionLog/Resources/views', 'actionlog');
        $this->loadViewsFrom(__DIR__.'/ActivityLog/Resources/views', 'activitylog');

        // Publish frontend JS asset
        $this->publishes([
            __DIR__ . '/../public/js' => public_path('vendor/log-management'),
        ], 'log-management-assets');
    }


    public function register()
    {
        //
    }
}
