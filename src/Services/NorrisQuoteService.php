<?php 

namespace Raducu\NorrisQuote\Services;

use Illuminate\Http\Client\Factory as HttpClient;
use Psr\Log\LoggerInterface;
use Raducu\NorrisQuote\Contracts\NorrisQuoteContract;

final class NorrisQuoteService implements NorrisQuoteContract
{
    /**
     * The API URL to fetch the quotes from.
     *
     * @var string
     */
    protected string $apiUrl;
    protected HttpClient $httpClient;

    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, HttpClient $httpClient)
    {
        $apiUrl = config('norrisquote');

        $this->apiUrl = $apiUrl['api_url'];
        $this->logger = $logger;
        $this->httpClient = $httpClient;
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
        $response = $this->httpClient->get($this->apiUrl);

        if ($response->failed()) {
            throw new \Exception($response['message'] ?? 'Failed to fetch data from the API', $response->status());
        }

        return $response->json();
    }
    
}