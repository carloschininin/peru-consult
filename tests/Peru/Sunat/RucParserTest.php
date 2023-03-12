<?php

declare(strict_types=1);

namespace Tests\Peru\Sunat;

use Peru\Sunat\Parser\HtmlRecaptchaParser;
use Peru\Sunat\RucParser;
use PHPUnit\Framework\TestCase;

final class RucParserTest extends TestCase
{
    private RucParser $parser;

    protected function setUp(): void
    {
        $this->parser = new RucParser(new HtmlRecaptchaParser());
    }

    public function testParseRucEmpty()
    {
        $company = $this->parser->parse('');
        $this->assertNull($company);
    }
}
