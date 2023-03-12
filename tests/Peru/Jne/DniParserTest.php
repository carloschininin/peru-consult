<?php

declare(strict_types=1);

namespace Tests\Peru\Jne;

use Peru\Jne\DniParser;
use PHPUnit\Framework\TestCase;

class DniParserTest extends TestCase
{
    private DniParser $parser;

    protected function setUp(): void
    {
        $this->parser = new DniParser();
    }

    /**
     * @testWith ["00000009"]
     *           ["00000003"]
     */
    public function testParseDni(string $dni)
    {
        $obj = json_decode('{"apeMatSoli": "PATERNO","apePatSoli": "MATERNO","nombreSoli": "NOMBRES"}');
        $person = $this->parser->parse($dni, $obj);

        $this->assertNotNull($person);
        $this->assertNotNull($person->codVerifica);
    }
}
