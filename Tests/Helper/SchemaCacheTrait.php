<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Helper;

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
            ->with('tx_schema')
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);
    }
}
