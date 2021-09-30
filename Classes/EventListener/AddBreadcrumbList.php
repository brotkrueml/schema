<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
final class AddBreadcrumbList
{
    private const DOKTYPES_TO_EXCLUDE = [
        PageRepository::DOKTYPE_RECYCLER,
        PageRepository::DOKTYPE_SPACER,
        PageRepository::DOKTYPE_SYSFOLDER,
    ];

    private TypoScriptFrontendController $controller;
    private ExtensionConfiguration $configuration;
    private ContentObjectRenderer $contentObjectRenderer;

    public function __construct(
        ContentObjectRenderer $contentObjectRenderer,
        ExtensionConfiguration $configuration,
        TypoScriptFrontendController $controller
    ) {
        $this->contentObjectRenderer = $contentObjectRenderer;
        $this->configuration = $configuration;
        $this->controller = $controller;
    }

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        $shouldEmbedBreadcrumbMarkup = (bool)$this->configuration->get('schema', 'automaticBreadcrumbSchemaGeneration');

        if (! $shouldEmbedBreadcrumbMarkup) {
            return;
        }

        $rootLine = [];
        foreach ($this->controller->rootLine as $page) {
            if ($page['is_siteroot'] ?? false) {
                break;
            }

            if ($page['nav_hide'] ?? false) {
                continue;
            }

            if (\in_array($page['doktype'] ?? PageRepository::DOKTYPE_DEFAULT, self::DOKTYPES_TO_EXCLUDE, true)) {
                continue;
            }

            $rootLine[] = $page;
        }

        if ($rootLine === []) {
            return;
        }

        $rootLine = \array_reverse($rootLine);
        $event->addType($this->buildBreadCrumbList($rootLine));
    }

    private function buildBreadCrumbList(array $rootLine): TypeInterface
    {
        $breadcrumbList = TypeFactory::createType('BreadcrumbList');
        foreach (\array_values($rootLine) as $index => $page) {
            $givenItemType = ($page['tx_schema_webpagetype'] ?? '') ?: 'WebPage';
            $itemType = TypeFactory::createType($givenItemType);

            $link = $this->contentObjectRenderer->typoLink_URL([
                'parameter' => (string)$page['uid'],
                'forceAbsoluteUrl' => true,
            ]);

            $itemType->setId($link);

            $item = TypeFactory::createType('ListItem')->setProperties([
                'position' => $index + 1,
                'name' => $page['nav_title'] ?: $page['title'],
                'item' => $itemType,
            ]);

            $breadcrumbList->addProperty('itemListElement', $item);
        }

        return $breadcrumbList;
    }
}
