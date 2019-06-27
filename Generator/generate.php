<?php

use Brotkrueml\Schema\Generator\Configuration\Configuration;
use Brotkrueml\Schema\Generator\Generator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../.Build/vendor/autoload.php';

$configuration = new Configuration();
$configuration->schemaPath = __DIR__ . '/Schema/schema.jsonld';
$configuration->modelTypeTraitPathTemplate = __DIR__ . '/../Classes/Model/TypeTrait/%sTrait.php';
$configuration->modelTypePathTemplate = __DIR__ . '/../Classes/Model/Type/%s.php';
$configuration->viewHelperTypePathTemplate = __DIR__ . '/../Classes/ViewHelper/Type/%sViewHelper.php';
$configuration->webPageTypeProviderTemplate = __DIR__ . '/../Classes/Provider/WebPageTypeProvider.php';

$loader = new FilesystemLoader(__DIR__ . '/Templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../.Build/twig_cache',
]);

try {
    (new Generator($configuration, $twig))->generate();
} catch (Throwable $e) {
    echo 'Could not generate, reason: ' . $e->getMessage();
}
