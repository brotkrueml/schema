<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddReturnTypeDeclarationFromYieldsRector;

return static function (RectorConfig $config): void {
    $config->import(LevelSetList::UP_TO_PHP_81);
    $config->import(SetList::CODE_QUALITY);
    $config->import(SetList::DEAD_CODE);
    $config->import(SetList::EARLY_RETURN);
    $config->import(SetList::TYPE_DECLARATION);
    $config->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);
    $config->import(PHPUnitSetList::PHPUNIT_EXCEPTION);
    $config->import(PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD);
    $config->import(PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER);

    $config->phpVersion(PhpVersion::PHP_81);

    $config->autoloadPaths([
        __DIR__ . '/.Build/vendor/autoload.php',
    ]);
    $config->paths([
        __DIR__ . '/Classes',
        __DIR__ . '/Tests',
    ]);
    $config->skip([
        __DIR__ . '/Classes/Model/Type/*',
        __DIR__ . '/Classes/ViewHelpers/Type/*',
        AddLiteralSeparatorToNumberRector::class,
        AddReturnTypeDeclarationFromYieldsRector::class => [
            __DIR__ . '/Tests/*',
        ],
        CountOnNullRector::class => [
            __DIR__ . '/Classes/ViewHelpers/BreadcrumbViewHelper.php',
        ],
        RecastingRemovalRector::class => [
            __DIR__ . '/Tests/Functional/ViewHelpers/ViewHelperTestCase.php',
        ],
        RemoveParentCallWithoutParentRector::class => [
            __DIR__ . '/Classes/AdminPanel/SchemaModule', // can be removed with minimum compatibility to TYPO3 v12 LTS
        ],
        ReturnTypeFromStrictTypedPropertyRector::class => [
            __DIR__ . '/Classes/Core/Model/AbstractType.php',
            __DIR__ . '/Classes/Core/Model/MultipleType.php',
        ],
    ]);
};
