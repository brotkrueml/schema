<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Cache;

use Brotkrueml\Schema\Compatibility\Compatibility;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
class PagesCacheService
{
    /** @var Compatibility */
    private $compatibility;

    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var FrontendInterface|null */
    private $cache;

    public function __construct(FrontendInterface $cache = null)
    {
        $this->compatibility = new Compatibility();
        $this->cache = $cache ?? $this->getCache();
    }

    private function getCache(): ?FrontendInterface
    {
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

        $identifier = 'pages';
        if ($this->compatibility->hasCachePrefixForCacheIdentifier()) {
            $identifier = 'cache_' . $identifier;
        }

        try {
            return $cacheManager->getCache($identifier);
        } catch (NoSuchCacheException $e) {
            return null;
        }
    }

    public function getMarkupFromCache(): ?string
    {
        $this->initialiseTypoScriptFrontendController();
        if ($this->cache instanceof FrontendInterface && $markup = $this->cache->get($this->getCacheIdentifier())) {
            return $markup;
        }

        return null;
    }

    private function getCacheIdentifier(): string
    {
        return $this->controller->newHash . '-tx-schema';
    }

    public function storeMarkupInCache(string $markup): void
    {
        if (!$this->cache instanceof FrontendInterface) {
            return;
        }

        $this->initialiseTypoScriptFrontendController();
        $this->cache->set(
            $this->getCacheIdentifier(),
            $markup,
            ['pageId_' . $this->controller->page['uid']],
            $this->controller->get_cache_timeout()
        );
    }

    private function initialiseTypoScriptFrontendController(): void
    {
        if (!$this->controller) {
            // Cannot be done in constructor as an empty TSFE is injected via DI in TYPO3 v10
            $this->controller = $GLOBALS['TSFE'];
        }
    }

    /**
     * For testing purposes only!
     * @param TypoScriptFrontendController $controller
     */
    public function setTypoScriptFrontendController(TypoScriptFrontendController $controller): void
    {
        $this->controller = $controller;
    }
}
