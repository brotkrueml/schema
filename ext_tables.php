<?php
defined('TYPO3') or die();

(static function () {
    // Since TYPO3 v11.4 icons can be registered in Configuration/Icons.php
    if ((new TYPO3\CMS\Core\Information\Typo3Version())->getMajorVersion() > 10) {
        return;
    }

    if (!TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('adminpanel')) {
        return;
    }

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach (['documentation-google', 'documentation-schema', 'documentation-yandex', 'module-adminpanel'] as $icon) {
        $iconRegistry->registerIcon(
            'ext-schema-' . $icon,
            TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            [
                'source' => sprintf(
                    'EXT:%s/Resources/Public/Icons/%s.svg',
                    Brotkrueml\Schema\Extension::KEY,
                    $icon
                ),
            ]
        );
    }
})();
