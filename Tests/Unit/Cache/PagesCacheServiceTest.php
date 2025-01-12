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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

#[CoversClass(PagesCacheService::class)]
final class PagesCacheServiceTest extends TestCase
{
    private PagesCacheService $subject;
    private FrontendInterface&MockObject $cacheFrontendMock;

    private TypoScriptFrontendController&Stub $controllerStub;

    protected function setUp(): void
    {
        $this->cacheFrontendMock = $this->createMock(FrontendInterface::class);

        $this->controllerStub = self::createStub(TypoScriptFrontendController::class);
        $this->controllerStub->newHash = 'some-hash';
        $this->controllerStub->page = [
            'uid' => 42,
        ];

        $this->subject = new PagesCacheService($this->cacheFrontendMock);
        $this->subject->setTypoScriptFrontendController($this->controllerStub);
    }

    #[Test]
    public function getMarkupFromCacheReturnsNullWhenCacheEntryIsNotAvailable(): void
    {
        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('get')
            ->willReturn(false);

        self::assertNull($this->subject->getMarkupFromCache());
    }

    #[Test]
    public function getMarkupFromCacheReturnsMarkupFromCacheCorrectly(): void
    {
        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('get')
            ->with('some-hash-tx-schema')
            ->willReturn('some markup');

        self::assertSame('some markup', $this->subject->getMarkupFromCache());
    }

    #[Test]
    public function storeMarkupInCacheWithoutAdditionalCacheTagsSetsMarkupCorrectly(): void
    {
        $this->controllerStub
            ->method('getPageCacheTags')
            ->willReturn([]);

        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('set')
            ->with('some-hash-tx-schema', 'markup to store', ['pageId_42'], 86400);

        $this->subject->storeMarkupInCache('markup to store');
    }

    #[Test]
    public function storeMarkupInCacheSetsMarkupCorrectlyWithAdditionalCacheTagsSetsMarkupCorrectly(): void
    {
        $this->controllerStub
            ->method('getPageCacheTags')
            ->willReturn(['some_tag_1', 'some_tag_2']);

        $this->cacheFrontendMock
            ->expects(self::once())
            ->method('set')
            ->with('some-hash-tx-schema', 'markup to store', ['pageId_42', 'some_tag_1', 'some_tag_2'], 86400);

        $this->subject->storeMarkupInCache('markup to store');
    }
}
