<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

return [
    'ext-schema-documentation-google' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:' . Brotkrueml\Schema\Extension::KEY . '/Resources/Public/Icons/documentation-google.svg',
    ],
    'ext-schema-documentation-schema' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:' . Brotkrueml\Schema\Extension::KEY . '/Resources/Public/Icons/documentation-schema.svg',
    ],
    'ext-schema-documentation-yandex' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:' . Brotkrueml\Schema\Extension::KEY . '/Resources/Public/Icons/documentation-yandex.svg',
    ],
    'ext-schema-module-adminpanel' => [
        'provider' => TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:' . Brotkrueml\Schema\Extension::KEY . '/Resources/Public/Icons/module-adminpanel.svg',
    ],
];
