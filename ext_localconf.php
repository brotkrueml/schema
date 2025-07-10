<?php

use Brotkrueml\Schema\Extension;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Brotkrueml\Schema\AdminPanel\SchemaModule;
use Brotkrueml\Schema\AdminPanel\TypesInformation;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Extension::CACHE_IDENTIFIER] ??= [];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Extension::CACHE_IDENTIFIER]['groups'] ??= ['pages'];

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
