<?php
return [
    'frontend' => [
        'brotkrueml/schema/webpage-type' => [
            'target' => \Brotkrueml\Schema\Middleware\WebPageType::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
        'brotkrueml/schema/breadcrumblist' => [
            'target' => \Brotkrueml\Schema\Middleware\BreadcrumbList::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
    ],
];
