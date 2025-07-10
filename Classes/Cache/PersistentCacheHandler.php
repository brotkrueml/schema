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
readonly class PersistentCacheHandler
{
    public function __construct(
        private CacheIdentifierCreator $cacheIdentifierCreator,
        #[Autowire(service: Extension::CACHE_SERVICE_ID)]
        private FrontendInterface $persistentCache,
    ) {}

    public function getMarkup(ServerRequestInterface $request): ?string
    {
        $cacheIdentifier = $this->cacheIdentifierCreator->getCacheIdentifier($request);
        if ($this->persistentCache->has($cacheIdentifier)) {
            return $this->persistentCache->get($cacheIdentifier);
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

        $this->persistentCache->set(
            $this->cacheIdentifierCreator->getCacheIdentifier($request),
            $markup,
            $cacheTags,
            $cacheDataCollector->resolveLifetime(),
        );
    }
}
