<?php
defined('TYPO3_MODE') || die();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
    \Brotkrueml\Schema\Hook\PageRenderer\PostProcessHook::class . '->execute';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] =
    \Brotkrueml\Schema\Hook\TableConfiguration\Pages::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];
