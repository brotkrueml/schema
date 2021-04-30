<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Cache;

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
    private const CACHE_IDENTIFIER = 'pages';

    private ?TypoScriptFrontendController $controller = null;
    private ?FrontendInterface $cache;

    public function __construct(FrontendInterface $cache = null)
    {
        $this->cache = $cache ?? $this->getCache();
    }

    private function getCache(): ?FrontendInterface
    {
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

        try {
            return $cacheManager->getCache(self::CACHE_IDENTIFIER);
        } catch (NoSuchCacheException $e) {
            return null;
        }
    }

    public function getMarkupFromCache(): ?string
    {
        $this->initialiseTypoScriptFrontendController();
        if (!$this->cache instanceof FrontendInterface) {
            return null;
        }
        if (!($markup = $this->cache->get($this->getCacheIdentifier()))) {
            return null;
        }

        return $markup;
    }

    private function getCacheIdentifier(): string
    {
        /** @psalm-suppress PossiblyNullPropertyFetch */
        return $this->controller->newHash . '-tx-schema';
    }

    public function storeMarkupInCache(string $markup): void
    {
        if (!$this->cache instanceof FrontendInterface) {
            return;
        }

        $this->initialiseTypoScriptFrontendController();
        if ($this->controller !== null) {
            $this->cache->set(
                $this->getCacheIdentifier(),
                $markup,
                ['pageId_' . $this->controller->page['uid']],
                $this->controller->get_cache_timeout()
            );
        }
    }

    private function initialiseTypoScriptFrontendController(): void
    {
        if ($this->controller === null) {
            // Cannot be done in constructor as an empty TSFE is injected via DI in TYPO3 v10
            $this->controller = $GLOBALS['TSFE'];
        }
    }

    /**
     * For testing purposes only!
     */
    public function setTypoScriptFrontendController(TypoScriptFrontendController $controller): void
    {
        $this->controller = $controller;
    }
}
