<?php

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

(static function () {
    $tca = [
        'tx_schema_webpagetype' => [
            'exclude' => true,
            'label' => Brotkrueml\Schema\Extension::LANGUAGE_PATH_DATABASE . ':pages.tx_schema_webpagetype',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', ''],
                ],
                'itemsProcFunc' => Brotkrueml\Schema\UserFunctions\FormEngine\WebPageTypes::class . '->get',
                'size' => 1,
                'maxitems' => 1,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
    ];

    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tca);

    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'pages',
        'tx_schema_structureddata',
        'tx_schema_webpagetype',
    );

    $position = TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('seo')
        ? 'after:canonical_link'
        : 'after:description';
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        '--palette--;' . Brotkrueml\Schema\Extension::LANGUAGE_PATH_DATABASE . ':pages.palette.structuredData;tx_schema_structureddata',
        '',
        $position,
    );
})();
