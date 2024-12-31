<?php

namespace Raducu\NorrisQuote;

use Illuminate\Support\ServiceProvider;
use Raducu\NorrisQuote\Services\NorrisQuoteService;

class NorrisQuoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('norrisquote', function () {
            return new NorrisQuoteService($this->app->make('Psr\Log\LoggerInterface'));
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
