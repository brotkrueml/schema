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
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class PagesCacheServiceTest extends TestCase
{
    private PagesCacheService $subject;
    private FrontendInterface&MockObject $cacheFrontendMock;

    private TypoScriptFrontendController&Stub $controllerStub;

    protected function setUp(): void
    {
        $this->cacheFrontendMock = $this->createMock(FrontendInterface::class);

        $this->controllerStub = $this->createStub(TypoScriptFrontendController::class);
        $this->controllerStub
            ->method('get_cache_timeout')
            ->willReturn(3600);
        $this->controllerStub->newHash = 'some-hash';
        $this->controllerStub->page = [
            'uid' => 42,
        ];

        $this->subject = new PagesCacheService($this->cacheFrontendMock);
        $this->subject->setTypoScriptFrontendController($this->controllerStub);
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
}
