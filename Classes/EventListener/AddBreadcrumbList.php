<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
final class AddBreadcrumbList
{
    private const DEFAULT_DOKTYPES_TO_EXCLUDE = [
        255, // Remove when compatibility with TYPO3 v12 is dropped
        PageRepository::DOKTYPE_SPACER,
        PageRepository::DOKTYPE_SYSFOLDER,
    ];

    public function __construct(
        private readonly Configuration $configuration,
        private readonly ContentObjectRenderer $contentObjectRenderer,
        private readonly TypeFactory $typeFactory,
    ) {}

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        if (! $this->configuration->automaticBreadcrumbSchemaGeneration) {
            return;
        }

        if ($event->isBreadcrumbListAlreadyDefined() && $this->configuration->allowOnlyOneBreadcrumbList) {
            return;
        }

        $doktypesToExclude = \array_merge(
            self::DEFAULT_DOKTYPES_TO_EXCLUDE,
            $this->configuration->automaticBreadcrumbExcludeAdditionalDoktypes,
        );
        $rootLine = [];
        /** @var TypoScriptFrontendController $frontendController */
        $frontendController = $event->getRequest()->getAttribute('frontend.controller');
        foreach ($frontendController->config['rootLine'] as $page) {
            if ($page['is_siteroot'] ?? false) {
                continue;
            }

            if ($page['hidden'] ?? false) {
                continue;
            }

            if ($page['nav_hide'] ?? false) {
                continue;
            }

            if (\in_array($page['doktype'] ?? PageRepository::DOKTYPE_DEFAULT, $doktypesToExclude, true)) {
                continue;
            }

            $rootLine[] = $page;
        }

        if ($rootLine === []) {
            return;
        }

        $event->addType($this->buildBreadCrumbList($rootLine));
    }

    /**
     * @param non-empty-array<int, array<string, mixed>> $rootLine
     */
    private function buildBreadCrumbList(array $rootLine): TypeInterface
    {
        $breadcrumbList = $this->typeFactory->create('BreadcrumbList');
        foreach (\array_values($rootLine) as $index => $page) {
            $itemType = $this->typeFactory->create('WebPage');

            $link = $this->contentObjectRenderer->typoLink_URL([
                'parameter' => (string)$page['uid'],
                'forceAbsoluteUrl' => true,
            ]);

            $itemType->setId($link);

            $item = $this->typeFactory->create('ListItem')->setProperties([
                'position' => $index + 1,
                'name' => $page['nav_title'] ?: $page['title'],
                'item' => $itemType,
            ]);

            $breadcrumbList->addProperty('itemListElement', $item);
        }

        return $breadcrumbList;
    }
}
