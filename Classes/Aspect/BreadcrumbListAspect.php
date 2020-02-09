<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Aspect;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type;
use Brotkrueml\Schema\Utility\Utility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class BreadcrumbListAspect implements AspectInterface
{
    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var ExtensionConfiguration */
    private $configuration;

    /** @var object|ContentObjectRenderer */
    private $contentObjectRenderer;

    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $configuration = null,
        ContentObjectRenderer $contentObjectRenderer = null
    ) {
        $this->controller = $controller ?: $GLOBALS['TSFE'];
        $this->configuration = $configuration ?: GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->contentObjectRenderer = $contentObjectRenderer ?: GeneralUtility::makeInstance(ContentObjectRenderer::class);
    }

    public function execute(SchemaManager $schemaManager): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $shouldEmbedBreadcrumbMarkup = (bool)$this->configuration->get('schema', 'automaticBreadcrumbSchemaGeneration');

        if (!$shouldEmbedBreadcrumbMarkup) {
            return;
        }

        $rootLine = [];
        foreach ($this->controller->rootLine as $page) {
            if ($page['is_siteroot']) {
                break;
            }

            if ($page['nav_hide']) {
                continue;
            }

            if ($page['doktype'] >= 199) {
                continue;
            }

            $rootLine[] = $page;
        }

        if (!empty($rootLine)) {
            $rootLine = \array_reverse($rootLine);
            $breadcrumbList = $this->buildBreadCrumbList($rootLine);
            $schemaManager->addType($breadcrumbList);
        }
    }

    private function buildBreadCrumbList(array $rootLine): Type\BreadcrumbList
    {
        $breadcrumbList = (new Type\BreadcrumbList());
        foreach ($rootLine as $index => $page) {
            $givenItemTypeClass = Utility::getNamespacedClassNameForType($page['tx_schema_webpagetype']);
            $webPageTypeClass = $givenItemTypeClass ?: Type\WebPage::class;

            /** @var AbstractType $itemType */
            $itemType = new $webPageTypeClass();

            $link = $this->contentObjectRenderer->typoLink_URL([
                'parameter' => $page['uid'],
                'forceAbsoluteUrl' => true,
            ]);

            $itemType->setId($link);

            $item = (new Type\ListItem())->setProperties([
                'position' => $index + 1,
                'name' => $page['nav_title'] ?: $page['title'],
                'item' => $itemType,
            ]);

            $breadcrumbList->addProperty('itemListElement', $item);
        }

        return $breadcrumbList;
    }
}
