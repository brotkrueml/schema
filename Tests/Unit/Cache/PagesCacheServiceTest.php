<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Cache;

use Brotkrueml\Schema\Cache\PagesCacheService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class PagesCacheServiceTest extends TestCase
{
    private PagesCacheService $subject;

    /** @var MockObject|FrontendInterface */
    private $cacheFrontendMock;

    /** @var Stub|TypoScriptFrontendController */
    private $controllerStub;

    protected function setUp(): void
    {
        $this->cacheFrontendMock = $this->createMock(FrontendInterface::class);

        $this->controllerStub = $this->createStub(TypoScriptFrontendController::class);
        $this->controllerStub
            ->method('get_cache_timeout')
            ->willReturn(3600);
        $this->controllerStub->newHash = 'some-hash';
        $this->controllerStub->page = ['uid' => 42];

        $this->subject = new PagesCacheService($this->cacheFrontendMock);
        $this->subject->setTypoScriptFrontendController($this->controllerStub);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function getMarkupFromCacheReturnsNullWhenCacheIsNotAvailable(): void
    {
        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->willThrowException(new NoSuchCacheException());

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        $subject = new PagesCacheService(null);
        $subject->setTypoScriptFrontendController($this->controllerStub);

        self::assertNull($subject->getMarkupFromCache());
    }

    /**
     * @test
     */
    public function getMarkupFromCacheReturnsNullWhenCacheEntryIsNotAvailable(): void
    {
        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('get')
            ->willReturn(false);

        self::assertNull($this->subject->getMarkupFromCache());
    }

    /**
     * @test
     */
    public function getMarkupFromCacheReturnsMarkupFromCacheCorrectly(): void
    {
        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('get')
            ->with('some-hash-tx-schema')
            ->willReturn('some markup');

        self::assertSame('some markup', $this->subject->getMarkupFromCache());
    }

    /**
     * @test
     */
    public function storeMarkupInCacheSetsMarkupCorrectly(): void
    {
        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('set')
            ->with('some-hash-tx-schema', 'markup to store', ['pageId_42'], 3600);

        $this->subject->storeMarkupInCache('markup to store');
    }

    /**
     * @test
     */
    public function correctCacheIdentifierIsUsed(): void
    {
        $cacheManagerMock = $this->createStub(CacheManager::class);
        $cacheManagerMock
            ->expects(self::once())
            ->method('getCache')
            ->with('pages');

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerMock);

        new PagesCacheService(null);
    }
}
