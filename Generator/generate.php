<?php

use Brotkrueml\Schema\Generator\Generator;
use Brotkrueml\Schema\Generator\File\Writer;

require __DIR__ . '/../.Build/vendor/autoload.php';

$configurationPath = __DIR__ . '/Configuration/';

try {
    (new Generator($configurationPath . 'schema.jsonld'))
        ->addWriter(new Writer(
            __DIR__ . '/Templates/Model.php.template',
            __DIR__ . '/../Classes/Model/Type/'
        ))
        ->addWriter(new Writer(
            __DIR__ . '/Templates/ViewHelper.php.template',
            __DIR__ . '/../Classes/ViewHelper/Type/',
            'ViewHelper'
        ))
        ->generate();
} catch (Throwable $e) {
    echo 'Could not generate, reason: ' . $e->getMessage();
}
