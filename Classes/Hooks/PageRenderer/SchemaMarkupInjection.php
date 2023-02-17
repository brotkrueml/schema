<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Hooks\PageRenderer;

use Brotkrueml\Schema\Adapter\ApplicationType;
use Brotkrueml\Schema\Adapter\ExtensionAvailability;
use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Manager\SchemaManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class SchemaMarkupInjection
{
    private readonly ApplicationType $applicationType;
    private TypoScriptFrontendController $controller;

    /**
     * @var array<string, mixed>
     */
    private array $configuration;

    private SchemaManager $schemaManager;
    private PagesCacheService $pagesCacheService;
    private ExtensionAvailability $extensionAvailability;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $extensionConfiguration = null,
        SchemaManager $schemaManager = null,
        PagesCacheService $pagesCacheService = null,
        ApplicationType $applicationType = null,
        ExtensionAvailability $extensionAvailability = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->applicationType = $applicationType ?? new ApplicationType();
        if (! $this->applicationType->isBackend()) {
            $this->controller = $controller ?? $GLOBALS['TSFE'];
            $extensionConfiguration ??= GeneralUtility::makeInstance(ExtensionConfiguration::class);
            $this->configuration = $extensionConfiguration->get('schema') ?? [];
            $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);
            $this->pagesCacheService = $pagesCacheService ?? GeneralUtility::makeInstance(PagesCacheService::class);
            $this->extensionAvailability = $extensionAvailability ?? new ExtensionAvailability();
            $this->eventDispatcher = $eventDispatcher ?? GeneralUtility::makeInstance(EventDispatcherInterface::class);
        }
    }

    /**
     * @noinspection PhpUnusedParameterInspection
     */
    public function execute(?array &$params, PageRenderer &$pageRenderer): void
    {
        if ($this->applicationType->isBackend()) {
            return;
        }

        if (! $this->isMarkupToBeEmbedded()) {
            return;
        }

        $result = $this->pagesCacheService->getMarkupFromCache();
        if ($result === null) {
            /** @var RenderAdditionalTypesEvent $event */
            $event = $this->eventDispatcher->dispatch(new RenderAdditionalTypesEvent($this->schemaManager->hasWebPage()));
            foreach ($event->getAdditionalTypes() as $additionalType) {
                $this->schemaManager->addType($additionalType);
            }

            $result = $this->schemaManager->renderJsonLd();
            if ($result !== '') {
                $this->pagesCacheService->storeMarkupInCache($result);
            }
        }

        if ($result === '') {
            return;
        }

        if ($this->configuration['embedMarkupInBodySection'] ?? false) {
            $pageRenderer->addFooterData($result);
        } else {
            $pageRenderer->addHeaderData($result);
        }
    }

    private function isMarkupToBeEmbedded(): bool
    {
        if (! $this->extensionAvailability->isSeoAvailable()) {
            return true;
        }

        if (! ($this->controller->page['no_index'] ?? false)) {
            return true;
        }

        return (bool)($this->configuration['embedMarkupOnNoindexPages'] ?? true);
    }
}
