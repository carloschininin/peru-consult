<?php

declare(strict_types=1);

namespace Tests\Peru\Jne\Async;

use React\EventLoop\Loop;
use function React\Async\await;
use Peru\Http\Async\ClientInterface;
use Peru\Http\Async\HttpClient;
use Peru\Jne\Async\Dni;
use Peru\Jne\DniParser;
use Peru\Reniec\Person;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;
use React\Promise\FulfilledPromise;
use Tests\Peru\Sunat\Async\HttpClientStub;

class DniTest extends TestCase
{
    private LoopInterface $loop;

    private Dni $consult;

    protected function setUp(): void
    {
        $this->loop = Loop::get();
        $this->consult = new Dni(new HttpClientStub(new HttpClient($this->loop)), new DniParser());
    }

    /**
     * @throws \Exception|\Throwable when the promise is rejected
     */
    public function testGetDni()
    {
         $promise = $this->consult->get('41489925');

         /**@var $person Person */
         $person = await($promise);

         $this->assertNotNull($person);
         $this->assertEquals('41489925', $person->dni);
    }

    /**
     * @throws \Exception|\Throwable when the promise is rejected
     */
    public function testServerEmptyResponse()
    {
        $stub = $this->getMockBuilder(ClientInterface::class)->getMock();
        $stub->method('postAsync')->willReturn(new FulfilledPromise(''));

        /**@var $stub ClientInterface */
        $client = new Dni($stub, new DniParser());
        $person = await($client->get('0999'));

        $this->assertNull($person);
    }

    protected function tearDown(): void
    {
        $this->loop->run();
    }
}
