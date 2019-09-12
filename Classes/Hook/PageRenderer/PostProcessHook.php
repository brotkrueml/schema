<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Hook\PageRenderer;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class PostProcessHook
{
    private $controller;
    private $configuration;

    public function __construct(?TypoScriptFrontendController $controller = null, ?ExtensionConfiguration $configuration = null)
    {
        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $this->configuration = $configuration ?: GeneralUtility::makeInstance(ExtensionConfiguration::class);
    }

    public function execute(/** @noinspection PhpUnusedParameterInspection */ ?array &$params, PageRenderer &$pageRenderer): void
    {
        if (TYPO3_MODE !== 'FE') {
            return;
        }

        if (!$this->isPageIndexed()) {
            return;
        }

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $result = $schemaManager->renderJsonLd();

        if (!$result) {
            return;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $shouldEmbedMarkupInBodySection = $this->configuration->get('schema', 'embedMarkupInBodySection');

        if ($shouldEmbedMarkupInBodySection) {
            $pageRenderer->addFooterData($result);
        } else {
            $pageRenderer->addHeaderData($result);
        }
    }

    private function isPageIndexed(): bool
    {
        if (!ExtensionManagementUtility::isLoaded('seo')) {
            return true;
        }

        return $this->controller->page['no_index'] === 0;
    }
}
