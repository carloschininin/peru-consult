<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/11/2017
 * Time: 19:59.
 */

declare(strict_types=1);

namespace Tests\Peru\Sunat;

use DateTime;
use Exception;
use Peru\Http\{CurlClient, EmptyResponseDecorator};
use Peru\Sunat\{Parser\HtmlRecaptchaParser, Ruc, RucParser};
use PHPUnit\Framework\TestCase;

/**
 * Class RucTest
 * @package Tests\Peru\Sunat
 */
class RucTest extends TestCase
{
    private ?Ruc $cs = null;

    public function setUp(): void
    {
        $this->cs = new Ruc(
            new ClientStubDecorator(new EmptyResponseDecorator(new CurlClient())),
            new RucParser(new HtmlRecaptchaParser()));
    }

    /**
     * @dataProvider rucProviders
     *
     * @throws Exception
     */
    public function testGetRuc(string $ruc)
    {
        $company = $this->cs->get($ruc);

        $this->assertNotEmpty($company->ruc);
        $this->assertNotEmpty($company->razonSocial);
        $this->assertNotEmpty($company->estado);
        $this->assertNotEmpty($company->condicion);
        $this->assertNotEmpty($company->direccion);
        $this->assertNotEmpty($company->fechaInscripcion);
        $this->assertTrue(is_array($company->cpeElectronico));
        $this->assertNotNull(new DateTime($company->fechaInscripcion));
        $this->assertNotEmpty($company->departamento);
        $this->assertNotEmpty($company->provincia);
        $this->assertNotEmpty($company->distrito);
    }

    public function testJsonEncode()
    {
        $company = $this->cs->get('10401510465');

        $this->assertNotNull($company);
        $json = json_encode($company);
        $this->assertJson($json);
        $obj = json_decode($json);
        $this->assertNotEmpty($obj->ruc);
    }

    public function testInvalidResponse()
    {
        $company = $this->cs->get('20000000001');

        $this->assertNull($company);
    }

    public function testInvalidRuc()
    {
        $cs = new Ruc(new CurlClient(), new RucParser(new HtmlRecaptchaParser()));
        $company = $cs->get('20000000001');

        $this->assertNull($company);
    }

    public static function rucProviders(): array
    {
        return [
            ['20440374248'], // 20550263948LA LIBERTAD
            ['20550263948'],
            ['20493919271'], // MADRE DE DIOS
            ['20146806679'], // SAN MARTIN
        ];
    }
}
