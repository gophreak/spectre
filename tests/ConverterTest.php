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
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testReadFromCSV
     */
    public function testReadFromCSV()
    {
        $converter = new Converter();

        $persons = $converter->readFromCSV('tests/samples/example.csv');

        self::assertCount(18, $persons);

        self::assertSame([
            [
                'title' => 'Mr',
                'first_name' => 'John',
                'initial' => null,
                'last_name' => 'Smith',
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Jane',
                'initial' => null,
                'last_name' => 'Smith',
            ],
            [
                'title' => 'Mister',
                'first_name' => 'John',
                'initial' => null,
                'last_name' => 'Doe',
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Bob',
                'initial' => null,
                'last_name' => 'Lawblaw',
            ],
            [
                'title' => 'Mr',
                'first_name' => null,
                'initial' => null,
                'last_name' => 'Smith',
            ],
            [
                'title' => 'Mrs',
                'first_name' => null,
                'initial' => null,
                'last_name' => 'Smith',
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Craig',
                'initial' => null,
                'last_name' => 'Charles',
            ],
            [
                'title' => 'Mr',
                'first_name' => null,
                'initial' => 'M',
                'last_name' => 'Mackie',
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Jane',
                'initial' => null,
                'last_name' => 'McMaster',
            ],
            [
                'title' => 'Mr',
                'first_name' => 'Tom',
                'initial' => null,
                'last_name' => 'Staff',
            ],
            [
                'title' => 'Mr',
                'first_name' => 'John',
                'initial' => null,
                'last_name' => 'Doe',
            ],
            [
                'title' => 'Dr',
                'first_name' => null,
                'initial' => 'P',
                'last_name' => 'Gunn',
            ],
            [
                'title' => 'Dr',
                'first_name' => 'Joe',
                'initial' => null,
                'last_name' => 'Bloggs',
            ],
            [
                'title' => 'Mrs',
                'first_name' => null,
                'initial' => null,
                'last_name' => 'Bloggs',
            ],
            [
                'title' => 'Ms',
                'first_name' => 'Claire',
                'initial' => null,
                'last_name' => 'Robbo',
            ],
            [
                'title' => 'Prof',
                'first_name' => 'Alex',
                'initial' => null,
                'last_name' => 'Brogan',
            ],
            [
                'title' => 'Mrs',
                'first_name' => 'Faye',
                'initial' => null,
                'last_name' => 'Hughes-Eastwood',
            ],
            [
                'title' => 'Mr',
                'first_name' => null,
                'initial' => 'F',
                'last_name' => 'Fredrickson',
            ],
        ], $persons);
    }

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
        $converter = new MockConverter();

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

        $converter = new MockConverter();
        $converter->parseRecord('Mr');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyAnds
     */
    public function testParseRecordExceptions_TooManyAnds()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many and\'s and/or &\'s');

        $converter = new MockConverter();
        $converter->parseRecord('Mr and Mrs and Lady');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyAnds_2
     */
    public function testParseRecordExceptions_TooManyAnds_2()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many and\'s and/or &\'s');

        $converter = new MockConverter();
        $converter->parseRecord('Mr & Mrs & Lady');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyAnds_3
     */
    public function testParseRecordExceptions_TooManyAnds_3()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many and\'s and/or &\'s');

        $converter = new MockConverter();
        $converter->parseRecord('Mr & Mrs and Lady');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyParts
     */
    public function testParseRecordExceptions_TooManyParts()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many parts');

        $converter = new MockConverter();
        $converter->parseRecord('Mr John James Smith');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testParseRecordExceptions_TooManyParts_2
     */
    public function testParseRecordExceptions_TooManyParts_2()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Too many parts');

        $converter = new MockConverter();
        $converter->parseRecord('Mr John P Smith');
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testProcessMultiPerson
     */
    public function testProcessMultiPerson()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Not enough parts');

        $converter = new MockConverter();
        // test invalid use case for this function
        $converter->processMultiPerson(['Mr', 'P' ,'Smith'], 0);
    }

    /**
     * vendor/bin/phpunit -c phpunit.xml --stderr --filter ConverterTest::testProcessMultiPerson_EmptyNoError
     */
    public function testProcessMultiPerson_EmptyNoError()
    {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Not enough parts');

        $converter = new MockConverter();
        // test invalid use case for this function
        $p = $converter->processMultiPerson([], 0);
    }
}

class MockConverter extends Converter {
    /**
     * Allow public access for testing.
     *
     * @overrides Converter::parseRecord
     */
    public function parseRecord(string $record): array
    {
        return parent::parseRecord($record); // TODO: Change the autogenerated stub
    }

    /**
     * Allow public access for testing.
     *
     * @overrides Converter::processMultiPerson
     */
    public function processMultiPerson(array $parts, int $index): array
    {
        return parent::processMultiPerson($parts, $index); // TODO: Change the autogenerated stub
    }
}