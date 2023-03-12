<?php

declare(strict_types=1);

namespace Tests\Peru\Sunat\Async;

use Peru\Http\Async\ClientInterface;
use React\Promise\PromiseInterface;
use Tests\Peru\Sunat\ClientStubDecorator;

class HttpClientStub implements ClientInterface
{
    public function __construct(private readonly ClientInterface $client)
    {
    }

    /**
     * Make GET Request.
     */
    public function getAsync(string $url, array $headers = []): PromiseInterface
    {
        return $this->client->getAsync(ClientStubDecorator::getNewUrl($url), $headers);
    }

    /**
     * Post Request.
     */
    public function postAsync(string $url, $data, array $headers = []): PromiseInterface
    {
        return $this->client->postAsync(ClientStubDecorator::getNewUrl($url), $data, $headers);
    }
}