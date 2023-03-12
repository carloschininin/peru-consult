<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/04/2018
 * Time: 09:33.
 */
declare(strict_types=1);

namespace Tests\Peru\Sunat;

use Peru\Http\CurlClient;
use Peru\Sunat\UserValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class UserValidatorTest.
 */
class UserValidatorTest extends TestCase
{
    private UserValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new UserValidator(new ClientStubDecorator(new CurlClient()));
    }

    public function testValidezCorrect()
    {
        $result = $this->validator->valid('20440890254', 'FACTURAJ');

        $this->assertTrue($result);
    }

    public function testValidezInCorrect()
    {
        $result = $this->validator->valid('20000000001', 'INVALID');

        $this->assertFalse($result);
    }
}
