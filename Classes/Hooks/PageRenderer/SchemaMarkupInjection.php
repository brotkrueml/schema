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
use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class SchemaMarkupInjection
{
    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var ExtensionConfiguration */
    private $configuration;

    /** @var SchemaManager */
    private $schemaManager;

    /** @var FrontendInterface */
    private $cache;

    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $extensionConfiguration = null,
        SchemaManager $schemaManager = null,
        FrontendInterface $cache = null
    ) {
        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);

        $extensionConfiguration = $extensionConfiguration ?? GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->configuration = $extensionConfiguration->get('schema');

        $this->cache = $cache ?? $this->getCache();
    }

    private function getCache(): ?FrontendInterface
    {
        $identifier = 'pages';
        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 10000000) {
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
        if (TYPO3_MODE !== 'FE') {
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
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $event = new ShouldEmbedMarkupEvent($this->controller->page, true);

        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >= 10000000) {
            $eventDispatcher = $objectManager->get(EventDispatcher::class);
            $event = $eventDispatcher->dispatch($event);
        }

        $signalSlotDispatcher = $objectManager->get(Dispatcher::class);
        $signalSlotDispatcher->dispatch(__CLASS__, 'shouldEmbedMarkup', [$event]);

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

            $aspects[] = new $aspectInstance;
        }

        return $aspects;
    }
}
