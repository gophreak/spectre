<?php

require_once 'bootstrap.php';

use Spectre\Converter;

$converter = new Converter();

if ($argc === 1) {
    echo 'Please provide a filepath' . PHP_EOL;

    exit;
}

$persons = $converter->readFromCSV($argv[1]);

var_dump($persons);
