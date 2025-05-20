<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Caching;

use Brotkrueml\Schema\Extension;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Cache\CacheDataCollector;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent;

/**
 * @internal
 */
#[AsEventListener]
final readonly class StoreMarkupInPersistentCache
{
    public function __construct(
        private CacheIdentifierCreator $cacheIdentifierCreator,
        #[Autowire(service: Extension::CACHE_SERVICE_ID)]
        private FrontendInterface $persistentCache,
        private RuntimeCacheHandler $runtimeCacheHandler,
    ) {}

    public function __invoke(AfterCachedPageIsPersistedEvent $event): void
    {
        $markup = $this->runtimeCacheHandler->getMarkup();
        if (! \is_string($markup)) {
            return;
        }

        /** @var CacheDataCollector $cacheDataCollector */
        $cacheDataCollector = $event->getRequest()->getAttribute('frontend.cache.collector');
        $cacheTags = \array_map(
            static fn(CacheTag $cacheTag): string => $cacheTag->name,
            $cacheDataCollector->getCacheTags(),
        );

        $this->persistentCache->set(
            $this->cacheIdentifierCreator->getCacheIdentifier($this->getRequest()),
            $markup,
            $cacheTags,
            $event->getCacheLifetime(),
        );
    }

    /**
     * Currently, we can't use the request object from the event as it does not provide
     * all necessary attributes for creating the cache identifier.
     */
    public function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
