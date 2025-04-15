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
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Cache\CacheInstruction;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

#[CoversClass(PagesCacheService::class)]
final class PagesCacheServiceTest extends TestCase
{
    private PagesCacheService $subject;
    private MockObject $cacheFrontendMock;
    private Stub $controllerStub;
    private ServerRequestInterface $request;

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

        $this->request = $this->buildRequest();
        $GLOBALS['TYPO3_REQUEST'] = $this->request;
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TYPO3_REQUEST']);
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
    public function getMarkupFromCacheReturnsNullIfCachingIsDisabledViaCacheInstruction(): void
    {
        $cacheInstruction = new CacheInstruction();
        $cacheInstruction->disableCache('Test');
        $GLOBALS['TYPO3_REQUEST'] = $this->request->withAttribute('frontend.cache.instruction', $cacheInstruction);

        $this->cacheFrontendMock
            ->expects(self::never())
            ->method('get')
            ->with('some-hash-tx-schema');

        self::assertNull($this->subject->getMarkupFromCache());
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

    #[Test]
    public function storeMarkupInCacheDoesNotSetMarkupIfCachingIsDisabledViaCacheInstruction(): void
    {
        $cacheInstruction = new CacheInstruction();
        $cacheInstruction->disableCache('Test');
        $GLOBALS['TYPO3_REQUEST'] = $this->request->withAttribute('frontend.cache.instruction', $cacheInstruction);

        $this->cacheFrontendMock
            ->expects(self::never())
            ->method('set');

        $this->subject->storeMarkupInCache('markup to store');
    }

    private function buildRequest(): ServerRequestInterface
    {
        return new class implements ServerRequestInterface {
            private ?CacheInstruction $cacheInstruction;

            public function __construct()
            {
                $this->cacheInstruction = \class_exists(CacheInstruction::class) ? new CacheInstruction() : null;
            }

            public function getProtocolVersion(): string
            {
                throw new \Exception('unused');
            }

            public function withProtocolVersion(string $version): MessageInterface
            {
                throw new \Exception('unused');
            }

            public function getHeaders(): array
            {
                throw new \Exception('unused');
            }

            public function hasHeader(string $name): bool
            {
                throw new \Exception('unused');
            }

            public function getHeader(string $name): array
            {
                throw new \Exception('unused');
            }

            public function getHeaderLine(string $name): string
            {
                throw new \Exception('unused');
            }

            public function withHeader(string $name, $value): MessageInterface
            {
                throw new \Exception('unused');
            }

            public function withAddedHeader(string $name, $value): MessageInterface
            {
                throw new \Exception('unused');
            }

            public function withoutHeader(string $name): MessageInterface
            {
                throw new \Exception('unused');
            }

            public function getBody(): StreamInterface
            {
                throw new \Exception('unused');
            }

            public function withBody(StreamInterface $body): MessageInterface
            {
                throw new \Exception('unused');
            }

            public function getRequestTarget(): string
            {
                throw new \Exception('unused');
            }

            public function withRequestTarget(string $requestTarget): RequestInterface
            {
                throw new \Exception('unused');
            }

            public function getMethod(): string
            {
                throw new \Exception('unused');
            }

            public function withMethod(string $method): RequestInterface
            {
                throw new \Exception('unused');
            }

            public function getUri(): UriInterface
            {
                throw new \Exception('unused');
            }

            public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
            {
                throw new \Exception('unused');
            }

            public function getServerParams(): array
            {
                throw new \Exception('unused');
            }

            public function getCookieParams(): array
            {
                throw new \Exception('unused');
            }

            public function withCookieParams(array $cookies): ServerRequestInterface
            {
                throw new \Exception('unused');
            }

            public function getQueryParams(): array
            {
                throw new \Exception('unused');
            }

            public function withQueryParams(array $query): ServerRequestInterface
            {
                throw new \Exception('unused');
            }

            public function getUploadedFiles(): array
            {
                throw new \Exception('unused');
            }

            public function withUploadedFiles(array $uploadedFiles): ServerRequestInterface
            {
                throw new \Exception('unused');
            }

            public function getParsedBody(): void
            {
                throw new \Exception('unused');
            }

            public function withParsedBody($data): ServerRequestInterface
            {
                throw new \Exception('unused');
            }

            public function getAttributes(): array
            {
                throw new \Exception('unused');
            }

            public function getAttribute(string $name, $default = null)
            {
                if ($name === 'frontend.cache.instruction') {
                    return $this->cacheInstruction;
                }

                throw new \Exception('name not supported');
            }

            public function withAttribute(string $name, $value): ServerRequestInterface
            {
                if ($name === 'frontend.cache.instruction') {
                    $this->cacheInstruction = $value;
                    return $this;
                }

                throw new \Exception('name not supported');
            }

            public function withoutAttribute(string $name): ServerRequestInterface
            {
                throw new \Exception('unused');
            }
        };
    }
}
