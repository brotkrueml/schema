<?php

use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\TypoScript\SchemaContentObject;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Brotkrueml\Schema\AdminPanel\SchemaModule;
use Brotkrueml\Schema\AdminPanel\TypesInformation;

defined('TYPO3') || die();

if (isset($GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'])) {
    // Since TYPO3 v13.2 the addRootLineFields are not necessary anymore
    // This configuration can be removed once compatibility with TYPO3 v12 is gone
    // @see https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/13.2/Deprecation-103752-ObsoleteGLOBALSTYPO3_CONF_VARSFEaddRootLineFields.html
    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',nav_hide,tx_schema_webpagetype';
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
    SchemaMarkupInjection::class . '->execute';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Extension::CACHE_IDENTIFIER] ??= [];

// This configuration can be removed once compatibility with TYPO3 v11 is gone
$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects']['SCHEMA'] = SchemaContentObject::class;

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
