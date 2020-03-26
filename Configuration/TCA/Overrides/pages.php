<?php
(function () {
    $fields = [
        'tx_schema_webpagetype' => [
            'exclude' => true,
            'label' => 'LLL:EXT:schema/Resources/Private/Language/locallang_db.xlf:pages.tx_schema_webpagetype',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => \Brotkrueml\Schema\Provider\WebPageTypeProvider::getTypesForTcaSelect(),
                'size' => 1,
                'maxitems' => 1,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
    ];

    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('seo')) {
        $fields['tx_schema_webpagetype']['displayCond'] = 'FIELD:no_index:=:0';
    }

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $fields);

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'pages',
        'tx_schema_structureddata',
        'tx_schema_webpagetype'
    );
})();
