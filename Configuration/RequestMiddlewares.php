<?php

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Injection\MarkupInjectionMiddleware;

return [
    'frontend' => [
        'brotkrueml/schema/markup-injection' => [
            'target' => MarkupInjectionMiddleware::class,
            'before' => [
                'typo3/cms-core/cache-timout',
            ],
            'after' => [
                'typo3/cms-adminpanel/renderer',
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
    ],
];
