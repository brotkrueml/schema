<?php
defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_schema_webpagetype';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
    Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class . '->execute';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_IDENTIFIER] ??= [];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER] ??= [];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['frontend'] ??= TYPO3\CMS\Core\Cache\Frontend\PhpFrontend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['backend'] ??= TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['options'] ??= ['defaultLifetime' => 0];

$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects']['SCHEMA'] = \Brotkrueml\Schema\TypoScript\SchemaContentObject::class;

if (TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('adminpanel')) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['adminpanel']['modules']['ext-schema'] = [
        'module' => Brotkrueml\Schema\AdminPanel\SchemaModule::class,
        'after' => ['tsdebug'],
        'submodules' => [
            'types' => [
                'module' => Brotkrueml\Schema\AdminPanel\TypesInformation::class,
            ],
        ],
    ];
}
