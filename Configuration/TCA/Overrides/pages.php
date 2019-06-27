<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function () {
    $fields = [
        'tx_schema_webpagetype' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:schema/Resources/Private/Language/locallang_db.xlf:pages.tx_schema_webpagetype',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => \Brotkrueml\Schema\Provider\WebPageTypeProvider::getTypesForTcaSelect(),
                'size' => 1,
                'maxitems' => 1
            ],
        ],
    ];

    ExtensionManagementUtility::addTCAcolumns('pages', $fields);

    ExtensionManagementUtility::addFieldsToPalette(
        'pages',
        'tx_schema_structureddata',
        'tx_schema_webpagetype'
    );
});
