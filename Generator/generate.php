<?php

use Brotkrueml\Schema\Generator\Configuration\Configuration;
use Brotkrueml\Schema\Generator\Generator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../.Build/vendor/autoload.php';

$configuration = new Configuration();
$configuration->schemaPath = __DIR__ . '/Schema/schema.jsonld';
$configuration->modelTypePathTemplate = __DIR__ . '/../Classes/Model/Type/%s.php';
$configuration->viewHelperTypePathTemplate = __DIR__ . '/../Classes/ViewHelpers/Type/%sViewHelper.php';
$configuration->typeModelsTemplate = __DIR__ . '/../Configuration/TxSchema/TypeModels.php';

$loader = new FilesystemLoader(__DIR__ . '/Templates');
$twig = new Environment($loader, [
    'cache' => false,
]);

try {
    (new Generator($configuration, $twig))->generate();
} catch (Throwable $e) {
    echo 'Could not generate, reason: ' . $e->getMessage();
}
