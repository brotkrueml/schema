<?php
defined('TYPO3_MODE') or die();

(function ($extensionKey = 'schema') {
    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_schema_webpagetype';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
        \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class . '->execute';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] =
        \Brotkrueml\Schema\Hooks\TableConfiguration\Pages::class;

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];

    $cacheIdentifier = 'tx_' . $extensionKey;
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier] = [];
    }

    $coreCacheIdentifier = 'tx_' . $extensionKey . '_core';
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier] = [];
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier]['frontend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier]['frontend'] = \TYPO3\CMS\Core\Cache\Frontend\PhpFrontend::class;
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier]['backend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier]['backend'] = \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier]['options'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$coreCacheIdentifier]['options']['defaultLifetime'] = 0;
    }

    if (!(new Brotkrueml\Schema\Compatibility\Compatibility())->isPsr14EventDispatcherAvailable()) {
        $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
        );
        $signalSlotDispatcher->connect(
            \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class,
            'shouldEmbedMarkup',
            \Brotkrueml\Schema\EventListener\EmbedMarkupDependingOnNoIndexPageField::class,
            '__invoke'
        );
        $signalSlotDispatcher->connect(
            \Brotkrueml\Schema\Core\Model\AbstractType::class,
            'registerAdditionalTypeProperties',
            \Brotkrueml\Schema\EventListener\RegisterTypePropertiesMovedFromOfficialToPending::class,
            '__invoke'
        );
    }

    // @internal no official hooks
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect']['breadcrumbList']
        = \Brotkrueml\Schema\Aspect\BreadcrumbListAspect::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect']['webPage']
        = \Brotkrueml\Schema\Aspect\WebPageAspect::class;
})();
