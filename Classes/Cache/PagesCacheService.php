<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Cache;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
class PagesCacheService
{
    private ?TypoScriptFrontendController $controller = null;

    public function __construct(
        private readonly FrontendInterface $cache,
    ) {}

    public function getMarkupFromCache(): ?string
    {
        $this->initialiseTypoScriptFrontendController();

        return $this->cache->get($this->getCacheIdentifier()) ?: null;
    }

    private function getCacheIdentifier(): string
    {
        return $this->controller->newHash . '-tx-schema';
    }

    public function storeMarkupInCache(string $markup): void
    {
        $this->initialiseTypoScriptFrontendController();
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

    /**
     * For testing purposes only!
     */
    public function setTypoScriptFrontendController(TypoScriptFrontendController $controller): void
    {
        $this->controller = $controller;
    }
}
