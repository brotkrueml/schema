<?php
defined('TYPO3_MODE') || die();

(function ($extensionKey='schema') {
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

    if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) < 10000000) {
        $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
        );
        $signalSlotDispatcher->connect(
            \Brotkrueml\Schema\Core\Model\AbstractType::class,
            'registerAdditionalTypeProperties',
            \Brotkrueml\Schema\EventListener\RegisterTypePropertiesMovedFromOfficialToPending::class,
            '__invoke'
        );
    }
})();
