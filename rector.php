<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
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
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(LevelSetList::UP_TO_PHP_74);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_EXCEPTION);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_MOCK);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/Classes',
        __DIR__ . '/Tests',
    ]);

    $parameters->set(Option::AUTOLOAD_PATHS, [__DIR__ . '/.Build/vendor/autoload.php']);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);

    $parameters->set(Option::SKIP, [
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
