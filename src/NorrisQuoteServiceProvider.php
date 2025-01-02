<?php

namespace Raducu\NorrisQuote;

use Illuminate\Support\ServiceProvider;
use Raducu\NorrisQuote\Services\NorrisQuoteService;
use Illuminate\Http\Client\Factory as HttpClient;

class NorrisQuoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('norrisquote', function ($app) {
            return new NorrisQuoteService(
                $app->make('Psr\Log\LoggerInterface'),
                $app->make(HttpClient::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('norrisquote.php') 
        ], 'norrisquote-config');
    }
}
