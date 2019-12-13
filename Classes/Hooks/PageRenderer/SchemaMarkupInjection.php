<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Hooks\PageRenderer;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Aspect\AspectInterface;
use Brotkrueml\Schema\Aspect\BreadcrumbListAspect;
use Brotkrueml\Schema\Aspect\WebPageAspect;
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class SchemaMarkupInjection
{
    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var ExtensionConfiguration */
    private $configuration;

    /** @var SchemaManager */
    private $schemaManager;

    private $aspects = [];

    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $extensionConfiguration = null,
        SchemaManager $schemaManager = null
    ) {
        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);

        $extensionConfiguration = $extensionConfiguration ?? GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->configuration = $extensionConfiguration->get('schema');
    }

    public function execute(?array &$params, PageRenderer &$pageRenderer): void
    {
        if (TYPO3_MODE !== 'FE') {
            return;
        }

        if (!$this->isPageIndexed()) {
            return;
        }

        foreach ($this->getAspects() as $aspect) {
            $aspect->execute($this->schemaManager);
        }

        $this->injectMarkupIntoPage($pageRenderer);
    }

    private function isPageIndexed(): bool
    {
        if (!ExtensionManagementUtility::isLoaded('seo')) {
            return true;
        }

        return $this->controller->page['no_index'] === 0;
    }

    private function injectMarkupIntoPage(PageRenderer $pageRenderer): void
    {
        $result = $this->schemaManager->renderJsonLd();

        if (!$result) {
            return;
        }

        if ($this->configuration['embedMarkupInBodySection'] ?? false) {
            $pageRenderer->addFooterData($result);
        } else {
            $pageRenderer->addHeaderData($result);
        }
    }

    private function getAspects(): array
    {
        if (empty($this->aspects)) {
            return [
                new WebPageAspect(),
                new BreadcrumbListAspect(),
            ];
        }

        return $this->aspects;
    }

    /**
     * For testing purposes only!
     *
     * @param AspectInterface $aspect
     */
    public function addAspect(AspectInterface $aspect): void
    {
        $this->aspects[] = $aspect;
    }
}
