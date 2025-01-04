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

        $this->contentObjectRendererStub = self::createStub(ContentObjectRenderer::class);
        $this->typoScriptFrontendControllerStub = self::createStub(TypoScriptFrontendController::class);

        $this->requestStub = self::createStub(ServerRequestInterface::class);
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

        $this->typoScriptFrontendControllerStub->config['rootLine'] = [];
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

        $this->typoScriptFrontendControllerStub->config['rootLine'] = $rootLine;
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

        $this->typoScriptFrontendControllerStub->config['rootLine'] = [
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
        yield 'Root line with nav_title set' => [
            [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => 'A nav title page',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A nav title page","position":"1"}}',
        ];

        yield 'Root line with nav_hide set' => [
            [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 3,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '1',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Root line with a hidden page' => [
            [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 3,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'hidden' => '1',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Folder in root line should not be rendered' => [
            [
                [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
                    'title' => 'A folder',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        // @todo Remove when compatibility with TYPO3 v12 is dropped
        yield 'Recycler in root line should not be rendered' => [
            [
                [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 1,
                    'doktype' => 255,
                    'title' => 'A folder',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Menu separator in root line should not be rendered, but doktype 198' => [
            [
                [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_SPACER,
                    'title' => 'A menu separator',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => 198,
                    'title' => 'A page with doktype 198',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page with doktype 198","position":"1"}}',
        ];

        yield 'Doktype 200 should be rendered' => [
            [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => 200,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Doktype 300 should be rendered' => [
            [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => 300,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}',
        ];

        yield 'Doktype 43 (which is excluded via extension configuration) should not be rendered' => [
            [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page on level 1',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => 43,
                    'title' => 'A page on level 2',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page on level 3',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page on level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page on level 3","position":"2"}]}',
        ];
    }

    #[Test]
    public function rootLineWithDifferentWebPageTypeSet(): never
    {
        self::markTestSkipped('Skipped, see https://github.com/brotkrueml/schema/issues/121');

        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: true);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->contentObjectRendererStub,
            new TypeFactory(),
        );

        $this->typoScriptFrontendControllerStub->config['rootLine'] = [
            [
                'uid' => 1,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Site root page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '1',
                'tx_schema_webpagetype' => '',
            ],
            [
                'uid' => 2,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'A page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => 'ItemPage',
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
