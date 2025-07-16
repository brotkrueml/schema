<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Cache;

use Brotkrueml\Schema\Extension;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\CacheDataCollector;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * @internal
 */
readonly class MarkupCacheHandler
{
    public function __construct(
        #[Autowire(service: Extension::CACHE_MARKUP_SERVICE_ID)]
        private FrontendInterface $markupCache,
        #[Autowire(service: 'cache.runtime')]
        private FrontendInterface $runtimeCache,
    ) {}

    public function getMarkup(): ?string
    {
        $pageCacheIdentifier = $this->getCacheIdentifier();
        if ($this->markupCache->has($pageCacheIdentifier)) {
            return $this->markupCache->get($pageCacheIdentifier);
        }

        return null;
    }

    public function storeMarkup(string $markup, ServerRequestInterface $request): void
    {
        /** @var CacheDataCollector $cacheDataCollector */
        $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
        $cacheTags = \array_map(
            static fn(CacheTag $cacheTag): string => $cacheTag->name,
            $cacheDataCollector->getCacheTags(),
        );

        $this->markupCache->set(
            $this->getCacheIdentifier(),
            $markup,
            $cacheTags,
            $cacheDataCollector->resolveLifetime(),
        );
    }

    public function getCacheIdentifier(): string
    {
        $pageCacheIdentifier = $this->runtimeCache->get(Extension::RUNTIME_CACHE_ENTRY_IDENTIFIER);
        if ($pageCacheIdentifier === false) {
            throw UnknownPageCacheIdentifierException::create();
        }

        return $pageCacheIdentifier;
    }
}
