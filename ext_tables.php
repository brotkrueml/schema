<?php
defined('TYPO3') or die();

(function () {
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
