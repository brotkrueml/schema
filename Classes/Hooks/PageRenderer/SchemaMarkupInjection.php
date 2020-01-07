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
use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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

    private $aspects = [];

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

    private function getCache(): FrontendInterface
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
            foreach ($this->getAspects() as $aspect) {
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
        $embedMarkup = true;

        if (ExtensionManagementUtility::isLoaded('seo')) {
            $embedMarkup = $this->controller->page['no_index'] === 0;
        }

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $event = new ShouldEmbedMarkupEvent($this->controller->page, $embedMarkup);

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
