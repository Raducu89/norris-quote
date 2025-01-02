<?php 

namespace Raducu\NorrisQuote\Contracts;

/**
 * The contract for the NorrisQuote service.
 */
interface NorrisQuoteContract
{
    public function getRandomQuote(): string;
}

