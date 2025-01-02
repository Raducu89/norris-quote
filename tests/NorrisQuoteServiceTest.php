<?php

namespace Tests\Unit;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Http;

class NorrisQuoteServiceTest extends TestCase
{
    protected string $apiUrl = 'https://api.chucknorris.io/jokes/random';

    /**
     * Define package service providers required for the test.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            'Raducu\NorrisQuote\NorrisQuoteServiceProvider',
        ];
    }

    /**
     * Test if the service successfully responds with an HTTP OK status.
     * 
     * @return void
     */
    public function testServiceRespondsSuccessfully(): void
    {
        // Mock the HTTP request to ensure it does not depend on the external API.
        Http::fake([
            $this->apiUrl => Http::response(['value' => 'A Chuck Norris joke'], 200),
        ]);

        $response = Http::get($this->apiUrl);

        $this->assertTrue($response->ok(), 'Expected a successful HTTP response.');
    }

    /**
     * Test if the response includes the 'value' parameter.
     * 
     * @return void
     */
    public function testResponseIncludesValueParameter(): void
    {
        // Mock the HTTP request to provide a predictable response.
        Http::fake([
            $this->apiUrl => Http::response(['value' => 'A Chuck Norris joke'], 200),
        ]);

        $response = Http::get($this->apiUrl);
        $responseData = $response->json();

        $this->assertArrayHasKey('value', $responseData, "Response JSON should contain the 'value' key.");
    }
}
