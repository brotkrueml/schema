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
use TYPO3\CMS\Frontend\Cache\CacheInstruction;

/**
 * @internal
 */
final readonly class MarkupCacheHandler
{
    private const TRANSIENT_MARKUP_CACHE_IDENTIFIER = Extension::KEY . '_markup';

    public function __construct(
        #[Autowire(service: Extension::CACHE_MARKUP_SERVICE_ID)]
        private FrontendInterface $persistentCache,
        #[Autowire(service: 'cache.runtime')]
        private FrontendInterface $runtimeCache,
    ) {}

    public function getMarkup(): ?string
    {
        $pageCacheIdentifier = $this->getCacheIdentifier();
        if ($this->persistentCache->has($pageCacheIdentifier)) {
            return $this->persistentCache->get($pageCacheIdentifier);
        }
        if ($this->runtimeCache->has(self::TRANSIENT_MARKUP_CACHE_IDENTIFIER)) {
            // Page might not be cached, then the markup might be in the runtime cache
            return $this->runtimeCache->get(self::TRANSIENT_MARKUP_CACHE_IDENTIFIER);
        }

        return null;
    }

    public function storeMarkup(string $markup, ServerRequestInterface $request): void
    {
        /** @var CacheInstruction $cacheInstruction */
        $cacheInstruction = $request->getAttribute('frontend.cache.instruction');
        if (! $cacheInstruction->isCachingAllowed()) {
            // If caching is not allowed we have to store the markup in the transient cache for
            // usage in the admin panel.
            $this->runtimeCache->set(
                self::TRANSIENT_MARKUP_CACHE_IDENTIFIER,
                $markup,
            );
            return;
        }

        /** @var CacheDataCollector $cacheDataCollector */
        $cacheDataCollector = $request->getAttribute('frontend.cache.collector');
        $cacheTags = \array_map(
            static fn(CacheTag $cacheTag): string => $cacheTag->name,
            $cacheDataCollector->getCacheTags(),
        );

        $this->persistentCache->set(
            $this->getCacheIdentifier(),
            $markup,
            $cacheTags,
            $cacheDataCollector->resolveLifetime(),
        );
    }

    public function getCacheIdentifier(): string
    {
        $pageCacheIdentifier = $this->runtimeCache->get(Extension::RUNTIME_CACHE_PAGE_CACHE_IDENTIFIER);
        if ($pageCacheIdentifier === false) {
            throw UnknownPageCacheIdentifierException::create();
        }

        return $pageCacheIdentifier;
    }
}
