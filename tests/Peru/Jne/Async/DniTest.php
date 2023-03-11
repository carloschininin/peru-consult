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
    /**
     * @var LoopInterface
     */
    private $loop;
    /**
     * @var Dni
     */
    private $consult;

    protected function setUp(): void
    {
        $this->loop = Loop::get();
        $this->consult = new Dni(new HttpClientStub(new HttpClient($this->loop)), new DniParser());
    }

    /**
     * @throws \Exception when the promise is rejected
     */
    public function testGetDni()
    {
         $this->consult->setRequestToken('097n0wui1QSNq9fIvsgrvRMD3HpX94k_daIKOOtfB909CCH4I6yIMF2xGS-oL5f9JcuQLxi0r7NaifLl7ywzetCamoqIInRRVLFNGwvf_-o1:gwx3eTdFP_Dluq92Nv3eX7qSJKg-MgnbxwHnhR57Q_JIfdvuXJsT1vDd926nUDXsvv7HcpJFuDh3yCyMfYEMY8BOZ4YkTFVyHC6EFW4Hboo1');
         $promise = $this->consult->get('48004836');
         /**@var $person Person */
         $person = await($promise, $this->loop);

         $this->assertNotNull($person);
         $this->assertEquals('48004836', $person->dni);
    }

    /**
     * @throws \Exception when the promise is rejected
     */
    public function testServerEmptyResponse()
    {
        $stub = $this->getMockBuilder(ClientInterface::class)->getMock();
        $stub->method('postAsync')->willReturn(new FulfilledPromise(''));

        /**@var $stub ClientInterface */
        $client = new Dni($stub, new DniParser());
        $person = await($client->get('0999'), $this->loop);

        $this->assertNull($person);
    }

    protected function tearDown(): void
    {
        $this->loop->run();
    }
}
