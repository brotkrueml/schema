<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;

return static function (RectorConfig $config): void {
    $config->import(LevelSetList::UP_TO_PHP_74);
    $config->import(SetList::CODE_QUALITY);
    $config->import(SetList::DEAD_CODE);
    $config->import(SetList::EARLY_RETURN);
    $config->import(SetList::TYPE_DECLARATION);
    $config->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);
    $config->import(PHPUnitSetList::PHPUNIT_EXCEPTION);
    $config->import(PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD);
    $config->import(PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER);

    $config->phpVersion(PhpVersion::PHP_74);

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
        AddArrayParamDocTypeRector::class => [
            __DIR__ . '/Tests/*',
        ],
        AddArrayReturnDocTypeRector::class => [
            __DIR__ . '/Tests/*',
        ],
        AddLiteralSeparatorToNumberRector::class,
        CountOnNullRector::class => [
            __DIR__ . '/Classes/ViewHelpers/BreadcrumbViewHelper.php',
        ],
        ParamTypeDeclarationRector::class => [
            // because signature would not match anymore with parent class
            __DIR__ . '/Classes/TypoScript/SchemaContentObject.php',
        ],
        RecastingRemovalRector::class => [
            __DIR__ . '/Tests/Unit/ViewHelpers/ViewHelperTestCase.php',
        ],
        RemoveUnusedPromotedPropertyRector::class, // to avoid rector warning on PHP8.0 with codebase compatible with PHP7.4
        ReturnTypeDeclarationRector::class => [
            __DIR__ . '/Classes/Core/Model/AbstractType.php',
            __DIR__ . '/Classes/Core/Model/MultipleType.php',
        ],
        TypedPropertyRector::class => [
            // because $propertyNames must not be typed to be compatible with schema_* extensions
            __DIR__ . '/Classes/Core/Model/AbstractType.php',
        ],
    ]);
};
