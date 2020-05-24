<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Hooks\PageRenderer;

use Brotkrueml\Schema\Aspect\AspectInterface;
use Brotkrueml\Schema\Compatibility\Compatibility;
use Brotkrueml\Schema\Context\Typo3Mode;
use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class SchemaMarkupInjection
{
    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var array<string, mixed> */
    private $configuration;

    /** @var SchemaManager */
    private $schemaManager;

    /** @var FrontendInterface|null */
    private $cache;

    /** @var Dispatcher */
    private $signalSlotDispatcher;

    /** @var EventDispatcher */
    private $eventDispatcher;

    /** @var Compatibility */
    private $compatibility;

    /** @var Typo3Mode */
    private $typo3Mode;

    /** @psalm-suppress PropertyTypeCoercion */
    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $extensionConfiguration = null,
        SchemaManager $schemaManager = null,
        FrontendInterface $cache = null,
        $signalSlotDispatcher = null,
        $eventDispatcher = null
    ) {
        $this->compatibility = new Compatibility();

        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $extensionConfiguration = $extensionConfiguration ?? GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->configuration = $extensionConfiguration->get('schema');
        $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);
        $this->cache = $cache ?? $this->getCache();

        if ($signalSlotDispatcher !== false) {
            $this->signalSlotDispatcher =
                $signalSlotDispatcher instanceof Dispatcher
                    ? $signalSlotDispatcher
                    : GeneralUtility::makeInstance(Dispatcher::class);
        }

        if ($this->compatibility->isPsr14EventDispatcherAvailable()) {
            $this->eventDispatcher =
                $eventDispatcher instanceof EventDispatcher
                    ? $eventDispatcher
                    : GeneralUtility::makeInstance(EventDispatcher::class);
        }
    }

    private function getCache(): ?FrontendInterface
    {
        $identifier = 'pages';
        if ($this->compatibility->hasCachePrefixForCacheIdentifier()) {
            $identifier = 'cache_' . $identifier;
        }

        try {
            return GeneralUtility::makeInstance(CacheManager::class)->getCache($identifier);
        } catch (NoSuchCacheException $e) {
            return null;
        }
    }

    public function execute(?array &$params, PageRenderer &$pageRenderer): void
    {
        if ($this->getTypo3Mode()->isInBackendMode()) {
            return;
        }

        if (!$this->shouldEmbedMarkup()) {
            return;
        }

        $result = $this->getMarkupFromCache();
        if ($result === null) {
            foreach ($this->getRegisteredAspects() as $aspect) {
                $aspect->execute($this->schemaManager);
            }

            if ($result = $this->schemaManager->renderJsonLd()) {
                $this->storeMarkupInCache($result);
            }
        }

        if (!$result) {
            return;
        }

        if ($this->configuration['embedMarkupInBodySection'] ?? false) {
            $pageRenderer->addFooterData($result);
        } else {
            $pageRenderer->addHeaderData($result);
        }
    }

    private function shouldEmbedMarkup(): bool
    {
        $event = new ShouldEmbedMarkupEvent($this->controller->page, true);
        if ($this->eventDispatcher) {
            $event = $this->eventDispatcher->dispatch($event);
        }
        if ($this->signalSlotDispatcher) {
            $this->signalSlotDispatcher->dispatch(static::class, 'shouldEmbedMarkup', [$event]);
        }

        return $event->getEmbedMarkup();
    }

    private function getMarkupFromCache(): ?string
    {
        if ($this->cache instanceof FrontendInterface && $markup = $this->cache->get($this->getCacheIdentifier())) {
            return $markup;
        }

        return null;
    }

    private function getCacheIdentifier(): string
    {
        return $this->controller->newHash . '-tx-schema';
    }

    private function storeMarkupInCache(string $markup): void
    {
        if (!$this->cache instanceof FrontendInterface) {
            return;
        }

        $this->cache->set(
            $this->getCacheIdentifier(),
            $markup,
            ['pageId_' . $this->controller->page['uid']],
            $this->controller->get_cache_timeout()
        );
    }

    private function getRegisteredAspects(): array
    {
        $aspects = [];
        // This hook is only for internal use and will be transformed to PSR-14 event
        // when TYPO3 v10 is a minimum requirement
        foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect'] ?? [] as $aspect) {
            $aspectInstance = new $aspect();
            if (!$aspectInstance instanceof AspectInterface) {
                throw new \InvalidArgumentException(
                    \sprintf(
                        'Aspect "%s" must implement interface "%s"',
                        $aspect,
                        AspectInterface::class
                    ),
                    1583429697
                );
            }

            $aspects[] = $aspectInstance;
        }

        return $aspects;
    }

    private function getTypo3Mode(): Typo3Mode
    {
        if (!$this->typo3Mode) {
            $this->typo3Mode = new Typo3Mode();
        }

        return $this->typo3Mode;
    }

    /**
     * @param Typo3Mode $typo3Mode
     * @internal For testing purposes only!
     */
    public function setTypo3Mode(Typo3Mode $typo3Mode): void
    {
        $this->typo3Mode = $typo3Mode;
    }
}
