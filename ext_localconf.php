<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Brotkrueml\Schema\AdminPanel\SchemaModule;
use Brotkrueml\Schema\AdminPanel\TypesInformation;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];

if (ExtensionManagementUtility::isLoaded('adminpanel')) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['adminpanel']['modules']['ext-schema'] = [
        'module' => SchemaModule::class,
        'after' => ['tsdebug'],
        'submodules' => [
            'types' => [
                'module' => TypesInformation::class,
            ],
        ],
    ];
}
