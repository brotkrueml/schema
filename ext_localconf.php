<?php
defined('TYPO3') or die();

(function () {
    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_schema_webpagetype';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
        Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class . '->execute';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] =
        Brotkrueml\Schema\Hooks\TableConfiguration\Pages::class;

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];

    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_IDENTIFIER])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_IDENTIFIER] = [];
    }

    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER] = [];
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['frontend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['frontend'] = TYPO3\CMS\Core\Cache\Frontend\PhpFrontend::class;
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['backend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['backend'] = TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['options'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Brotkrueml\Schema\Extension::CACHE_CORE_IDENTIFIER]['options']['defaultLifetime'] = 0;
    }

    // @internal no official hooks
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect']['breadcrumbList']
        = Brotkrueml\Schema\Aspect\BreadcrumbListAspect::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect']['webPage']
        = Brotkrueml\Schema\Aspect\WebPageAspect::class;

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
})();
