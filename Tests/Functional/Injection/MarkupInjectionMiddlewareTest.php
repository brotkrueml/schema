<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\Injection;

use Brotkrueml\Schema\Injection\MarkupInjectionMiddleware;
use Brotkrueml\Schema\Injection\MarkupProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Frontend\Authentication\FrontendBackendUserAuthentication;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(MarkupInjectionMiddleware::class)]
final class MarkupInjectionMiddlewareTest extends FunctionalTestCase
{
    /**
     * @var list<string>
     */
    protected array $coreExtensionsToLoad = [
        'typo3/cms-adminpanel',
    ];

    /**
     * @var list<string>
     */
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    private RequestHandlerInterface $responseOutputHandler;

    protected function setUp(): void
    {
        parent::setup();

        $stream = $this->get(StreamFactoryInterface::class)->createStream('<body>some-content</body>');

        $this->responseOutputHandler = new class($stream) implements RequestHandlerInterface {
            public function __construct(
                private readonly Stream $stream,
            ) {}

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return (new Response())->withBody($this->stream);
            }
        };
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['BE_USER']);
        parent::tearDown();
    }

    #[Test]
    public function markupIsEmptyThenNothingIsChangedInResponse(): void
    {
        $request = new ServerRequest('/some/url', 'GET');
        $markupProviderStub = self::createStub(MarkupProvider::class);
        $markupProviderStub
            ->method('getMarkup')
            ->with($request)
            ->willReturn('');
        $subject = new MarkupInjectionMiddleware($markupProviderStub, $this->get(StreamFactoryInterface::class));

        $actual = $subject->process($request, $this->responseOutputHandler);
        $actual->getBody()->rewind();

        self::assertSame('<body>some-content</body>', $actual->getBody()->getContents());
    }

    #[Test]
    public function markupIsDefinedThenItIsAddedToTheResponse(): void
    {
        $request = new ServerRequest('/some/url', 'GET');
        $markupProviderStub = self::createStub(MarkupProvider::class);
        $markupProviderStub
            ->method('getMarkup')
            ->with($request)
            ->willReturn('{"some": "markup"}');
        $subject = new MarkupInjectionMiddleware($markupProviderStub, $this->get(StreamFactoryInterface::class));

        $actual = $subject->process($request, $this->responseOutputHandler);
        $actual->getBody()->rewind();

        self::assertStringContainsString('<script type="application/ld+json">{"some": "markup"}</script>', $actual->getBody()->getContents());
    }

    #[Test]
    public function markupIsDefinedAndAdminPanelIsActivatedButNotOpenThenIdIsNotAddedToScriptTag(): void
    {
        $backendUserStub = self::createStub(FrontendBackendUserAuthentication::class);
        $backendUserStub
            ->method('getTSConfig')
            ->willReturn([
                'admPanel.' => [
                    'enable.' => [
                        'ext-schema' => 1,
                    ],
                ],
            ]);
        $GLOBALS['BE_USER'] = $backendUserStub;

        $request = new ServerRequest('/some/url', 'GET');
        $markupProviderStub = self::createStub(MarkupProvider::class);
        $markupProviderStub
            ->method('getMarkup')
            ->with($request)
            ->willReturn('{"some": "markup"}');
        $subject = new MarkupInjectionMiddleware($markupProviderStub, $this->get(StreamFactoryInterface::class));

        $actual = $subject->process($request, $this->responseOutputHandler);
        $actual->getBody()->rewind();

        self::assertStringContainsString('<script type="application/ld+json">{"some": "markup"}</script>', $actual->getBody()->getContents());
    }

    #[Test]
    public function markupIsDefinedAndAdminPanelIsActivatedAndOpenThenIdIsNotAddedToScriptTag(): void
    {
        $backendUserStub = self::createStub(FrontendBackendUserAuthentication::class);
        $backendUserStub
            ->method('getTSConfig')
            ->willReturn([
                'admPanel.' => [
                    'enable.' => [
                        'ext-schema' => 1,
                    ],
                ],
            ]);
        $backendUserStub->uc = [
            'AdminPanel' => [
                'display_top' => 1,
            ],
        ];
        $GLOBALS['BE_USER'] = $backendUserStub;

        $request = new ServerRequest('/some/url', 'GET');
        $markupProviderStub = self::createStub(MarkupProvider::class);
        $markupProviderStub
            ->method('getMarkup')
            ->with($request)
            ->willReturn('{"some": "markup"}');
        $subject = new MarkupInjectionMiddleware($markupProviderStub, $this->get(StreamFactoryInterface::class));

        $actual = $subject->process($request, $this->responseOutputHandler);
        $actual->getBody()->rewind();

        self::assertStringContainsString('<script type="application/ld+json" id="ext-schema-jsonld">{"some": "markup"}</script>', $actual->getBody()->getContents());
    }
}
