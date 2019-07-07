<?php

namespace Spectre;

use Exception;

/**
 * Converter class for converting a record into a person
 */
class Converter
{
    /** @var string KEY_TITLE */
    protected const KEY_TITLE       = 'title';

    /** @var string KEY_FIRST_NAME */
    protected const KEY_FIRST_NAME  = 'first_name';

    /** @var string KEY_INITIAL */
    protected const KEY_INITIAL     = 'initial';

    /** @var string KEY_LAST_NAME */
    protected const KEY_LAST_NAME   = 'last_name';

    /** @var array PERSON */
    protected const PERSON = [
        self::KEY_TITLE         => '',
        self::KEY_FIRST_NAME    => null,
        self::KEY_INITIAL       => null,
        self::KEY_LAST_NAME     => '',
    ];

    /**
     * Parse the record string of a given record, and return an assoc array of a person.
     *
     * @param string $record
     *
     * @return array
     */
    public function parseRecord(string $record): array
    {
        $parts = explode(' ', $record);

        $person = $this->parseParts($parts);

        return $person;
    }

    /**
     * Parse the individual parts into a person, by making decisions on the elements within the array.
     *
     * @param array $parts
     *
     * @return array
     * @throws Exception
     */
    protected function parseParts(array $parts): array
    {
        $numParts = count($parts);
        // Title and Surname must be set!
        if ($numParts < 2) {
            throw new Exception('Not enough parts');
        }

        // more than one person
        if (($intersect = array_intersect($parts, ['and', '&']))) {
            if (count($intersect) > 1) {
                throw new Exception('Too many and\'s and/or &\'s');
            }

            return $this->processMultiPerson($parts, array_keys($intersect)[0]);
        }

        // we know too much!
        if ($numParts > 3) {
            throw new Exception('Too many parts');
        }

        $person = self::PERSON;
        if ($numParts == 2) {
            list($title, $lastName) = $parts;
            $person[self::KEY_TITLE] = $title;
            $person[self::KEY_LAST_NAME] = $lastName;

            return $person;
        }

        list($title, $initialName, $lastName) = $parts;
        $person[self::KEY_TITLE] = $title;
        $person[self::KEY_LAST_NAME] = $lastName;

        if (strlen($initialName) === 1 || (strlen($initialName) === 2 && $initialName[1] === '.')) {
            $person[self::KEY_INITIAL] = $initialName[0];
        } else {
            $person[self::KEY_FIRST_NAME] = $initialName;
        }

        return $person;
    }

    /**
     * Special case when there are multiple people in the field.
     *
     * @param array $parts
     *
     * @return array
     */
    protected function processMultiPerson(array $parts, int $index): array
    {
        $part1 = array_slice($parts, 0, $index);
        $part2 = array_slice($parts, $index + 1, count($parts) -1);

        // "Mr and Mrs Smith", for example...
        if (count($part1) == 1 && count($part2) == 2) {
            $part1[] = $part2[1];
        }

        return [$this->parseParts($part1), $this->parseParts($part2)];
    }
}