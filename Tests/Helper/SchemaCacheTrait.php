<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Helper;

use Brotkrueml\Schema\Extension;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

trait SchemaCacheTrait
{
    public function defineCacheStubsWhichReturnEmptyEntry(): void
    {
        $cacheFrontendStub = $this->createStub(FrontendInterface::class);
        $cacheFrontendStub
            ->method('get')
            ->willReturn([]);

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with(Extension::CACHE_IDENTIFIER)
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);
    }
}
