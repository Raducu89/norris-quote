<?php 

namespace Raducu\NorrisQuote\Services;

use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;

final class NorrisQuoteService
{
    /**
     * The API URL to fetch the quotes from.
     *
     * @var string
     */
    protected string $apiUrl;

    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $apiUrl = require __DIR__ . '/../../config/config.php';
        $this->apiUrl = $apiUrl['api_url'];
        $this->logger = $logger;
    }

    /**
     * Fetch a random Chuck Norris quote from the API.
     *
     * @return string
     */
    public function getRandomQuote(): string
    {
        try {
            $response = $this->fetchQuoteFromApi();

            return $response['value'] ?? 'Chuck Norris does not give quotes.';
        } catch (\Exception $e) {
            $this->logger->error('Error fetching Chuck Norris quote: ' . $e->getMessage());
            return "Error: {$e->getMessage()}" . " ({$e->getCode()})";
        }
    }

    /**
     * Fetch data from the Chuck Norris API
     *
     * @return array
     * @throws \Exception
     */
    protected function fetchQuoteFromApi(): array
    {
        $response = Http::get($this->apiUrl);

        if ($response->failed()) {
            throw new \Exception($response['message'] ?? 'Failed to fetch data from the API', $response->status());
        }

        return $response->json();
    }
    
}