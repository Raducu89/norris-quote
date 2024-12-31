<?php 

namespace Raducu\NorrisQuote\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Raducu\NorrisQuote\Services\NorrisQuoteService
 */
class NorrisQuote extends Facade
{
    /**
     * Get the registered name of the component.
     * 
     * @return string
     */

    protected static function getFacadeAccessor(): string
    {
        return 'norrisquote';
    }
}