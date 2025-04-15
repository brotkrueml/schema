<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Cache;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Cache\CacheInstruction;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
#[Autoconfigure(public: true)]
class PagesCacheService
{
    private ?TypoScriptFrontendController $controller = null;

    public function __construct(
        private readonly FrontendInterface $cache,
    ) {}

    public function getMarkupFromCache(): ?string
    {
        $this->initialiseTypoScriptFrontendController();

        if (! $this->isCachingAllowed()) {
            return null;
        }

        $markup = $this->cache->get($this->getCacheIdentifier());

        return \is_string($markup) ? $markup : null;
    }

    private function getCacheIdentifier(): string
    {
        return $this->controller->newHash . '-tx-schema';
    }

    public function storeMarkupInCache(string $markup): void
    {
        $this->initialiseTypoScriptFrontendController();

        if (! $this->isCachingAllowed()) {
            return;
        }

        if ($this->controller instanceof TypoScriptFrontendController) {
            $this->cache->set(
                $this->getCacheIdentifier(),
                $markup,
                \array_merge(['pageId_' . ($this->controller->page['uid'] ?? 0)], $this->controller->getPageCacheTags()),
                86400,
            );
        }
    }

    private function initialiseTypoScriptFrontendController(): void
    {
        if (! $this->controller instanceof TypoScriptFrontendController) {
            $this->controller = $GLOBALS['TSFE'];
        }
    }

    private function isCachingAllowed(): bool
    {
        /** @var CacheInstruction|null $cacheInstruction */
        $cacheInstruction = $this->getRequest()->getAttribute('frontend.cache.instruction');
        if ($cacheInstruction instanceof CacheInstruction) {
            return $cacheInstruction->isCachingAllowed();
        }

        return true;
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    /**
     * For testing purposes only!
     */
    public function setTypoScriptFrontendController(TypoScriptFrontendController $controller): void
    {
        $this->controller = $controller;
    }
}
