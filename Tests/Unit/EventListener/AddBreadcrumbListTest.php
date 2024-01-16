<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\EventListener\AddBreadcrumbList;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Helper\TypeProviderWithFixturesTrait;
use Brotkrueml\Schema\Type\TypeFactory;
use Brotkrueml\Schema\Type\TypeProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

#[CoversClass(AddBreadcrumbList::class)]
final class AddBreadcrumbListTest extends TestCase
{
    use SchemaCacheTrait;
    use TypeProviderWithFixturesTrait;

    private ContentObjectRenderer&Stub $contentObjectRendererStub;
    private TypoScriptFrontendController&Stub $typoScriptFrontendControllerStub;
    private RenderAdditionalTypesEvent $event;
    private ServerRequestInterface&Stub $requestStub;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

        GeneralUtility::setSingletonInstance(TypeProvider::class, $this->getTypeProvider());

        $this->contentObjectRendererStub = $this->createStub(ContentObjectRenderer::class);
        $this->typoScriptFrontendControllerStub = $this->createStub(TypoScriptFrontendController::class);

        $this->requestStub = $this->createStub(ServerRequestInterface::class);
        $this->requestStub
            ->method('getAttribute')
            ->with('frontend.controller')
            ->willReturn($this->typoScriptFrontendControllerStub);

        $this->event = new RenderAdditionalTypesEvent(
            false,
            false,
            $this->requestStub,
        );
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    #[Test]
    public function noBreadcrumbIsAddedWhenItShouldNotBeEmbeddedViaConfiguration(): void
    {
        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: false);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    #[Test]
    public function withEmptyRootLineNoBreadcrumbIsAdded(): void
    {
        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: true);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $this->typoScriptFrontendControllerStub->rootLine = [];
        $subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    #[Test]
    #[DataProvider('rootLineProvider')]
    public function breadcrumbIsAddedCorrectly(array $rootLine, string $expected): void
    {
        $configuration = $this->buildConfiguration(
            automaticBreadcrumbSchemaGeneration: true,
            automaticBreadcrumbExcludeAdditionalDoktypes: [42, 43],
        );

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $this->typoScriptFrontendControllerStub->rootLine = $rootLine;
        $this->contentObjectRendererStub
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/the-page/');
        $subject->__invoke($this->event);

        $actual = $this->event->getAdditionalTypes();

        self::assertCount(1, $actual);
        self::assertSame($expected, $this->renderJsonLd($actual[0]));
    }

    #[Test]
    public function breadcrumbIsAlreadyAvailabledAndAddedWhenOnlyOneIsAllowed(): void
    {
        $configuration = $this->buildConfiguration(
            automaticBreadcrumbSchemaGeneration: true,
            allowOnlyOneBreadcrumbList: true,
        );

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $this->typoScriptFrontendControllerStub->rootLine = [
            1 => [
                'uid' => 1,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Site root page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '1',
                'tx_schema_webpagetype' => '',
            ],
        ];

        $event = new RenderAdditionalTypesEvent(false, true, $this->requestStub);
        $subject->__invoke($event);

        $actual = $this->event->getAdditionalTypes();

        self::assertSame([], $actual);
    }

    private function renderJsonLd(TypeInterface $type): string
    {
        $renderer = new Renderer();
        $renderer->addType($type);
        $jsonLd = $renderer->render();
        $templateParts = \explode('%s', Extension::JSONLD_TEMPLATE);

        return \str_replace($templateParts, '', $jsonLd);
    }

    public static function rootLineProvider(): iterable
    {
        yield 'Rootline with nav_title set' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => 'A nav title page',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A nav title page","position":"1"}}',
        ];

        yield 'Rootline with nav_hide set' => [
            [
                3 => [
                    'uid' => 3,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '1',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Rootline with a hidden page' => [
            [
                3 => [
                    'uid' => 3,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'hidden' => '1',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Rootline with siteroot not on first level' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                0 => [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'some other page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Folder in rootline should not be rendered' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
                    'title' => 'A folder',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                0 => [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Recycler in rootline should not be rendered' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_RECYCLER,
                    'title' => 'A folder',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                0 => [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Menu separator in rootline should not be rendered, but doktype 198' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => 198,
                    'title' => 'A page with doktype 198',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_SPACER,
                    'title' => 'A menu separator',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                0 => [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page with doktype 198","position":"1"}}',
        ];

        yield 'Doktype 200 should be rendered' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => 200,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Doktype 300 should be rendered' => [
            [
                2 => [
                    'uid' => 2,
                    'doktype' => 300,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Doktype 43 (which is excluded via extension configuration) should not be rendered' => [
            [
                4 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page on level 3',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                3 => [
                    'uid' => 2,
                    'doktype' => 43,
                    'title' => 'A page on level 2',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                2 => [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page on level 1',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                1 => [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page on level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page on level 3","position":"2"}]}',
        ];
    }

    #[Test]
    public function breadcrumbIsSortedCorrectly(): void
    {
        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: true);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $typoLinkMap = [
            [
                [
                    'parameter' => '2',
                    'forceAbsoluteUrl' => true,
                ],
                'https://example.org/level-1/',
            ],
            [
                [
                    'parameter' => '33',
                    'forceAbsoluteUrl' => true,
                ],
                'https://example.org/level-2/',
            ],
            [
                [
                    'parameter' => '22',
                    'forceAbsoluteUrl' => true,
                ],
                'https://example.org/level-3/',
            ],
            [
                [
                    'parameter' => '111',
                    'forceAbsoluteUrl' => true,
                ],
                'https://example.org/level-4/',
            ],
        ];
        $this->contentObjectRendererStub
            ->method('typoLink_URL')
            ->willReturnMap($typoLinkMap);
        $this->typoScriptFrontendControllerStub->rootLine = [
            [
                'uid' => 111,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Level 4',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => '',
            ],
            [
                'uid' => 22,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Level 3',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => '',
            ],
            [
                'uid' => 33,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Level 2',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => '',
            ],
            [
                'uid' => 2,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Level 1',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => '',
            ],
            [
                'uid' => 1,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Site root page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '1',
                'tx_schema_webpagetype' => '',
            ],
        ];

        $subject->__invoke($this->event);

        $actual = $this->event->getAdditionalTypes();
        $expected = '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-1/"},"name":"Level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-2/"},"name":"Level 2","position":"2"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-3/"},"name":"Level 3","position":"3"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-4/"},"name":"Level 4","position":"4"}]}';
        self::assertCount(1, $actual);
        self::assertSame($expected, $this->renderJsonLd($actual[0]));
    }

    #[Test]
    public function rootLineWithDifferentWebPageTypeSet(): void
    {
        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: true);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $this->typoScriptFrontendControllerStub->rootLine = [
            2 => [
                'uid' => 2,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'A page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => 'ItemPage',
            ],
            1 => [
                'uid' => 1,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Site root page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '1',
                'tx_schema_webpagetype' => '',
            ],
        ];
        $this->contentObjectRendererStub
            ->expects(self::once())
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/the-page/');

        $subject->__invoke($this->event);

        $actual = $this->event->getAdditionalTypes();
        $expected = '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}';
        self::assertCount(1, $actual);
        self::assertSame($expected, $this->renderJsonLd($actual[0]));
    }

    private function buildConfiguration(
        bool $automaticBreadcrumbSchemaGeneration = false,
        array $automaticBreadcrumbExcludeAdditionalDoktypes = [],
        bool $allowOnlyOneBreadcrumbList = false,
    ): Configuration {
        return new Configuration(
            false,
            $automaticBreadcrumbSchemaGeneration,
            $automaticBreadcrumbExcludeAdditionalDoktypes,
            $allowOnlyOneBreadcrumbList,
            false,
            false,
        );
    }
}
