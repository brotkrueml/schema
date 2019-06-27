<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */
return [
    'frontend' => [
        'brotkrueml/schema/webpage-type' => [
            'target' => \Brotkrueml\Schema\Middleware\WebPageType::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
    ],
];
