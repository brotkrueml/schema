<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [__DIR__ . '/Classes']);

    $parameters->set(Option::AUTOLOAD_PATHS, [__DIR__ . '/.Build/vendor/autoload.php']);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_72);

    $parameters->set(Option::SETS, [
        SetList::CODE_QUALITY,
        SetList::CODE_QUALITY_STRICT,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::PHP_52,
        SetList::PHP_53,
        SetList::PHP_54,
        SetList::PHP_55,
        SetList::PHP_56,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PHP_72,
//        SetList::TYPE_DECLARATION,
    ]);

    $parameters->set(Option::SKIP, [
        CountOnNullRector::class => [
            __DIR__ . '/Classes/ViewHelpers/BreadcrumbViewHelper.php'
        ],
    ]);
};
