<?php

declare (strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withSets([
        __DIR__ . '/.Build/vendor/brotkrueml/coding-standards/config/common.php',
    ])
    ->withParallel()
    ->withPaths([
        __DIR__ . '/Documentation',
    ]);
