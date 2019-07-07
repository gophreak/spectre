<?php

namespace Tests\Spectre;

use Exception;
use PHPUnit\Framework\TestCase;

use Spectre\Converter;

/**
 * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest
 */
class ConverterTest extends TestCase
{
    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordSuccesses
     */
    public function testParseRecordSuccesses()
    {
        $testCases = [
            'Mr John Smith' => [
                'title' => 'Mr',
                'first_name' => 'John',
                'initial' => null,
                'last_name' => 'Smith',
            ],
            'Mr and Mrs Smith' => [
                [
                    'title' => 'Mr',
                    'first_name' => null,
                    'initial' => null,
                    'last_name' => 'Smith',
                ],[
                    'title' => 'Mrs',
                    'first_name' => null,
                    'initial' => null,
                    'last_name' => 'Smith',
                ]
            ],
            'Mr J. Smith' => [
                'title' => 'Mr',
                'first_name' => null,
                'initial' => 'J',
                'last_name' => 'Smith',
            ],
            'Mr P Smith' => [
                'title' => 'Mr',
                'first_name' => null,
                'initial' => 'P',
                'last_name' => 'Smith',
            ]
        ];
        $converter = new Converter();

        foreach ($testCases as $input => $output) {
            self::assertSame($output, $converter->parseRecord($input));
        }
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_NotEnoughParts
     */
    public function testParseRecordExceptions_NotEnoughParts()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Not enough parts');

        $converter = new Converter();
        $converter->parseRecord('Mr');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyAnds
     */
    public function testParseRecordExceptions_TooManyAnds()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many and\'s and/or &\'s');

        $converter = new Converter();
        $converter->parseRecord('Mr and Mrs and Lady');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyAnds_2
     */
    public function testParseRecordExceptions_TooManyAnds_2()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many and\'s and/or &\'s');

        $converter = new Converter();
        $converter->parseRecord('Mr & Mrs & Lady');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyAnds_3
     */
    public function testParseRecordExceptions_TooManyAnds_3()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many and\'s and/or &\'s');

        $converter = new Converter();
        $converter->parseRecord('Mr & Mrs and Lady');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyParts
     */
    public function testParseRecordExceptions_TooManyParts()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many parts');

        $converter = new Converter();
        $converter->parseRecord('Mr John James Smith');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyParts_2
     */
    public function testParseRecordExceptions_TooManyParts_2()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many parts');

        $converter = new Converter();
        $converter->parseRecord('Mr John P Smith');
    }
}