<?php

declare(strict_types=1);

namespace Tests\Peru\Sunat\Async;

use React\EventLoop\Loop;
use function React\Async\await;
use Peru\Http\Async\HttpClient;
use Peru\Sunat\{Async\Ruc, Company, Parser\HtmlRecaptchaParser, RucParser};
use PHPUnit\Framework\TestCase;

class RucTest extends TestCase
{
    public const RUC_COMPANY = '20529752475';
    public const RUC_PERSON = '10414899256';

    /**
     * @throws \Throwable
     */
    public function testGetRucEmpresa()
    {
        $loop = Loop::get();
        $cs = new Ruc(new HttpClientStub(new HttpClient($loop)), new RucParser(new HtmlRecaptchaParser()));
        $promise = $cs->get(self::RUC_COMPANY);

        /**@var $company Company */
        $company = await($promise, $loop);

        $this->assertNotNull($company);
        $this->assertEquals(self::RUC_COMPANY, $company->ruc);
        $this->assertNotEmpty($company->razonSocial);

        $loop->run();
    }

    /**
     * @throws \Throwable
     */
    public function testGetRucPersona()
    {
        $loop = Loop::get();
        $cs = new Ruc(new HttpClientStub(new HttpClient($loop)), new RucParser(new HtmlRecaptchaParser()));
        $promise = $cs->get(self::RUC_PERSON);

        /**@var $company Company */
        $company = await($promise, $loop);

        $this->assertNotNull($company);
        $this->assertEquals(self::RUC_PERSON, $company->ruc);
        $this->assertNotEmpty($company->razonSocial);

        $loop->run();
    }
}
