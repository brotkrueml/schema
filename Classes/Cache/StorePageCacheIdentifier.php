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
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Event\BeforePageCacheIdentifierIsHashedEvent;

#[AsEventListener(
    identifier: 'ext-schema/store-page-cache-identifier',
)]
final readonly class StorePageCacheIdentifier
{
    public function __construct(
        #[Autowire(service: 'cache.runtime')]
        private FrontendInterface $runtimeCache,
    ) {}

    public function __invoke(BeforePageCacheIdentifierIsHashedEvent $event): void
    {
        $parameters = $event->getPageCacheIdentifierParameters();

        $identifier = $parameters['id'] . '_' . \hash('xxh3', \serialize($parameters));

        $this->runtimeCache->set(Extension::RUNTIME_CACHE_PAGE_CACHE_IDENTIFIER, $identifier);
    }
}
