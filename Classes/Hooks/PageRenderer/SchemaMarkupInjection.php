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
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Manager\SchemaManager;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;

final class SchemaMarkupInjection
{
    /**
     * @var array<string, string>
     */
    private array $configuration;
    private EventDispatcherInterface $eventDispatcher;
    private ExtensionAvailability $extensionAvailability;
    private PagesCacheService $pagesCacheService;
    private SchemaManager $schemaManager;

    public function __construct(
        private readonly ApplicationType $applicationType,
        private readonly ContainerInterface $locator,
    ) {}

    public function execute(?array &$params, PageRenderer $pageRenderer): void
    {
        if ($this->applicationType->isBackend()) {
            return;
        }

        $this->configuration = $this->locator->get(ExtensionConfiguration::class)->get(Extension::KEY) ?? [];
        $this->eventDispatcher = $this->locator->get(EventDispatcherInterface::class);
        $this->extensionAvailability = $this->locator->get(ExtensionAvailability::class);
        $this->pagesCacheService = $this->locator->get(PagesCacheService::class);
        $this->schemaManager = $this->locator->get(SchemaManager::class);

        if (! $this->isMarkupToBeEmbedded()) {
            return;
        }

        $result = $this->pagesCacheService->getMarkupFromCache();
        if ($result === null) {
            /** @var RenderAdditionalTypesEvent $event */
            $event = $this->eventDispatcher->dispatch(new RenderAdditionalTypesEvent(
                $this->schemaManager->hasWebPage(),
                $this->schemaManager->hasBreadcrumbList(),
                $this->getRequest(),
            ));
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

        if (! ($this->getRequest()->getAttribute('frontend.controller')->page['no_index'] ?? false)) {
            return true;
        }

        return (bool)($this->configuration['embedMarkupOnNoindexPages'] ?? true);
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
