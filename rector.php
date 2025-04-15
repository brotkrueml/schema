<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\ReplaceTestAnnotationWithPrefixedFunctionRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\PHPUnit\CodeQuality\Rector\Class_\RemoveDataProviderParamKeysRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/Classes',
        __DIR__ . '/Tests',
    ])
    ->withPhpSets()
    ->withAutoloadPaths([
        __DIR__ . '/.Build/vendor/autoload.php',
    ])
    ->withImportNames(
        importShortClasses: false,
        removeUnusedImports: true,
    )
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        earlyReturn: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_100,
    ])
    ->withRootFiles()
    ->withSkip([
        __DIR__ . '/Classes/Model/Type/*',
        __DIR__ . '/Classes/ViewHelpers/Type/*',
        PreferPHPUnitThisCallRector::class,
        RemoveDataProviderParamKeysRector::class,
        ReplaceTestAnnotationWithPrefixedFunctionRector::class,
    ]);
