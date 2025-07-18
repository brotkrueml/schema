<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Injection;

use Brotkrueml\Schema\Adapter\ExtensionAvailability;
use Brotkrueml\Schema\Cache\MarkupCacheHandler;
use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Manager\SchemaManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * @internal
 */
final readonly class MarkupProvider
{
    public function __construct(
        #[Autowire(service: 'tx_schema.configuration')]
        private Configuration $configuration,
        private EventDispatcherInterface $eventDispatcher,
        private ExtensionAvailability $extensionAvailability,
        private MarkupCacheHandler $markupCacheHandler,
        private SchemaManager $schemaManager,
    ) {}

    public function getMarkup(ServerRequestInterface $request): string
    {
        if (! $this->isMarkupToBeEmbedded($request)) {
            return '';
        }

        $markup = $this->markupCacheHandler->getMarkup();
        if ($markup === null) {
            $this->dispatchRenderAdditionalTypesEvent($request);
            $markup = $this->schemaManager->renderJsonLd();
            $this->markupCacheHandler->storeMarkup($markup, $request);
        }

        return $markup;
    }

    private function isMarkupToBeEmbedded(ServerRequestInterface $request): bool
    {
        if (! $this->extensionAvailability->isSeoAvailable()) {
            return true;
        }

        if (! ($request->getAttribute('frontend.page.information')->getPageRecord()['no_index'] ?? false)) {
            return true;
        }

        return $this->configuration->embedMarkupOnNoindexPages;
    }

    private function dispatchRenderAdditionalTypesEvent(ServerRequestInterface $request): void
    {
        /** @var RenderAdditionalTypesEvent $event */
        $event = $this->eventDispatcher->dispatch(new RenderAdditionalTypesEvent(
            $this->schemaManager->hasWebPage(),
            $this->schemaManager->hasBreadcrumbList(),
            $request,
        ));
        $this->schemaManager->addType(...$event->getAdditionalTypes());
        foreach ($event->getMainEntitiesOfWebPage() as $mainEntity) {
            $this->schemaManager->addMainEntityOfWebPage($mainEntity);
        }
    }
}
