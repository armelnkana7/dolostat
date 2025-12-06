<?php

namespace App\Providers;

use App\Helpers\RouteHelper;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('route-helper', function () {
            return new RouteHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register global helper alias - use a different check
        if (!defined('NAV_HELPER_DEFINED')) {
            define('NAV_HELPER_DEFINED', true);
            if (!function_exists('nav')) {
                function nav()
                {
                    return app('route-helper');
                }
            }
        }
    }
}
