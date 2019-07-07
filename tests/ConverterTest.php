<?php

namespace Tests\Spectre;

use PHPUnit\Framework\TestCase;

use Spectre\Converter;

/**
 * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest
 */
class ConverterTest extends TestCase
{
    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecord
     */
    public function testParseRecord()
    {
        $converter = new Converter();

        $person = $converter->parseRecord('Mr Smith');

        self::assertNotEmpty($person);
    }
}