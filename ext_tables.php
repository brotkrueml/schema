<?php
defined('TYPO3_MODE') || die('Access denied.');

(function () {
    $iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
    foreach (['documentation-google', 'documentation-schema', 'module-adminpanel'] as $icon) {
        $iconRegistry->registerIcon(
            'txschema-' . $icon,
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
