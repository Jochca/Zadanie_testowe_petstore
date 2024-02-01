<?php

namespace App\Providers;

use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Support\ServiceProvider;

class RequestFactoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(\Psr\Http\Message\RequestFactoryInterface::class, function ($app) {
            return new HttpFactory(); // Replace with your concrete implementation
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
