<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Caching;

use Brotkrueml\Schema\Caching\AdminPanelCacheHandler;
use Brotkrueml\Schema\Caching\PersistentCacheHandler;
use Brotkrueml\Schema\Caching\RuntimeCacheHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(AdminPanelCacheHandler::class)]
final class AdminPanelCacheHandlerTest extends TestCase
{
    private RuntimeCacheHandler&Stub $runtimeCacheHandlerStub;
    private MockObject $persistentCacheHandlerMock;
    private ServerRequestInterface&Stub $requestDummy;
    private AdminPanelCacheHandler $subject;

    protected function setUp(): void
    {
        $this->requestDummy = self::createStub(ServerRequestInterface::class);
        $this->runtimeCacheHandlerStub = self::createStub(RuntimeCacheHandler::class);
        $this->persistentCacheHandlerMock = $this->createMock(PersistentCacheHandler::class);

        $this->subject = new AdminPanelCacheHandler($this->persistentCacheHandlerMock, $this->runtimeCacheHandlerStub);
    }

    #[Test]
    public function markupIsReturnedFromRuntimeCacheThenPersistentCacheIsNotUsed(): void
    {
        $this->runtimeCacheHandlerStub
            ->method('getMarkup')
            ->willReturn('some-markup');

        $this->persistentCacheHandlerMock
            ->expects(self::never())
            ->method('getMarkup');

        $actual = $this->subject->getMarkup($this->requestDummy);

        self::assertSame('some-markup', $actual);
    }

    #[Test]
    public function runTimeCacheReturnsNullThenMarkupIsReturnedFromPersistentCache(): void
    {
        $this->runtimeCacheHandlerStub
            ->method('getMarkup')
            ->willReturn(null);

        $this->persistentCacheHandlerMock
            ->expects(self::once())
            ->method('getMarkup')
            ->with($this->requestDummy)
            ->willReturn('some-markup');

        $actual = $this->subject->getMarkup($this->requestDummy);

        self::assertSame('some-markup', $actual);
    }

    #[Test]
    public function runTimeCacheReturnsEmptyStringThenMarkupIsReturnedFromPersistentCache(): void
    {
        $this->runtimeCacheHandlerStub
            ->method('getMarkup')
            ->willReturn('');

        $this->persistentCacheHandlerMock
            ->expects(self::once())
            ->method('getMarkup')
            ->with($this->requestDummy)
            ->willReturn('some-markup');

        $actual = $this->subject->getMarkup($this->requestDummy);

        self::assertSame('some-markup', $actual);
    }

    #[Test]
    public function runTimeCacheReturnsEmptyStringAndPersistentCacheReturnsNullThenMarkupIsEmptyString(): void
    {
        $this->runtimeCacheHandlerStub
            ->method('getMarkup')
            ->willReturn('');

        $this->persistentCacheHandlerMock
            ->expects(self::once())
            ->method('getMarkup')
            ->with($this->requestDummy)
            ->willReturn(null);

        $actual = $this->subject->getMarkup($this->requestDummy);

        self::assertSame('', $actual);
    }
}
