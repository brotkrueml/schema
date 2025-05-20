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
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * @internal
 */
readonly class RuntimeCacheHandler
{
    private const RUNTIME_CACHE_IDENTIFIER = Extension::CACHE_IDENTIFIER . '_markup';

    public function __construct(
        #[Autowire(service: 'cache.runtime')]
        private FrontendInterface $runtimeCache,
    ) {}

    public function setMarkup(string $schemaMarkup): void
    {
        $this->runtimeCache->set(
            self::RUNTIME_CACHE_IDENTIFIER,
            $schemaMarkup,
        );
    }

    public function getMarkup(): ?string
    {
        if ($this->runtimeCache->has(self::RUNTIME_CACHE_IDENTIFIER)) {
            return $this->runtimeCache->get(self::RUNTIME_CACHE_IDENTIFIER);
        }

        return null;
    }
}
