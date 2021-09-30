<?php

declare (strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $header = <<<HEADER
This file is part of the "schema" extension for TYPO3 CMS.

For the full copyright and license information, please read the
LICENSE.txt file that was distributed with this source code.
HEADER;

    $containerConfigurator->import(__DIR__ . '/.Build/vendor/brotkrueml/coding-standards/config/common.php');

    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Comment\HeaderCommentFixer::class)
        ->call('configure', [[
            'comment_type' => 'comment',
            'header' => $header,
            'separate' => 'both',
        ]]);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PARALLEL, true);

    $parameters->set(
        Option::PATHS,
        [
            __DIR__ . '/Classes',
            __DIR__ . '/Configuration',
            __DIR__ . '/Tests',
        ]
    );

    $parameters->set(Option::SKIP, [
        \PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class => [
            __DIR__ . '/Classes/Extension.php',
        ],
        \PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class => [
            __DIR__ . '/Configuration/TCA/*',
        ],
    ]);
};
