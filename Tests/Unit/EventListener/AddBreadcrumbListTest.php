<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\EventListener\AddBreadcrumbList;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class AddBreadcrumbListTest extends TestCase
{
    use SchemaCacheTrait;

    /**
     * @var Stub|ContentObjectRenderer
     */
    private $contentObjectRendererStub;

    /**
     * @var Stub|ExtensionConfiguration
     */
    private $extensionConfigurationStub;

    /**
     * @var Stub|TypoScriptFrontendController
     */
    private $typoScriptFrontendControllerStub;

    private AddBreadcrumbList $subject;
    private RenderAdditionalTypesEvent $event;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $typeRegistryStub = $this->createStub(TypeRegistry::class);
        $map = [
            ['BreadcrumbList', FixtureType\BreadcrumbList::class],
            ['ItemPage', FixtureType\ItemPage::class],
            ['ListItem', FixtureType\ListItem::class],
            ['WebPage', FixtureType\WebPage::class],
        ];
        $typeRegistryStub
            ->method('resolveModelClassFromType')
            ->willReturnMap($map);

        GeneralUtility::setSingletonInstance(TypeRegistry::class, $typeRegistryStub);

        $this->contentObjectRendererStub = $this->createStub(ContentObjectRenderer::class);
        $this->extensionConfigurationStub = $this->createStub(ExtensionConfiguration::class);
        $this->typoScriptFrontendControllerStub = $this->createStub(TypoScriptFrontendController::class);

        $this->subject = new AddBreadcrumbList(
            $this->contentObjectRendererStub,
            $this->extensionConfigurationStub,
            $this->typoScriptFrontendControllerStub
        );

        $this->event = new RenderAdditionalTypesEvent(false);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function noBreadcrumbIsAddedWhenItShouldNotBeEmbeddedViaConfiguration(): void
    {
        $this->setAutomaticBreadcrumbSchemaGenerationConfigurationSetting(false);
        $this->subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    private function setAutomaticBreadcrumbSchemaGenerationConfigurationSetting(bool $value): void
    {
        $this->extensionConfigurationStub
            ->method('get')
            ->with(Extension::KEY, 'automaticBreadcrumbSchemaGeneration')
            ->willReturn($value);
    }

    /**
     * @test
     */
    public function withEmptyRootLineNoBreadcrumbIsAdded(): void
    {
        $this->setAutomaticBreadcrumbSchemaGenerationConfigurationSetting(true);
        $this->typoScriptFrontendControllerStub->rootLine = [];
        $this->subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    /**
     * @test
     * @dataProvider rootLineProvider
     */
    public function breadcrumbIsAddedCorrectly(array $rootLine, string $expected): void
    {
        $this->setAutomaticBreadcrumbSchemaGenerationConfigurationSetting(true);
        $this->typoScriptFrontendControllerStub->rootLine = $rootLine;
        $this->contentObjectRendererStub
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/the-page/');
        $this->subject->__invoke($this->event);

        self::assertCount(1, $this->event->getAdditionalTypes());
        self::assertSame($expected, $this->renderJsonLd($this->event->getAdditionalTypes()[0]));
    }

    private function renderJsonLd(TypeInterface $type): string
    {
        $renderer = new Renderer();
        $renderer->addType($type);
        $jsonLd = $renderer->render();
        $templateParts = \explode('%s', Extension::JSONLD_TEMPLATE);

        return \str_replace($templateParts, '', $jsonLd);
    }

    public function rootLineProvider(): iterable
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
    }

    /**
     * @test
     */
    public function breadcrumbIsSortedCorrectly(): void
    {
        $this->setAutomaticBreadcrumbSchemaGenerationConfigurationSetting(true);
        $typoLinkMap = [
            [['parameter' => '2', 'forceAbsoluteUrl' => true], 'https://example.org/level-1/'],
            [['parameter' => '33', 'forceAbsoluteUrl' => true], 'https://example.org/level-2/'],
            [['parameter' => '22', 'forceAbsoluteUrl' => true], 'https://example.org/level-3/'],
            [['parameter' => '111', 'forceAbsoluteUrl' => true], 'https://example.org/level-4/'],
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

        $this->subject->__invoke($this->event);

        $expected = '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-1/"},"name":"Level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-2/"},"name":"Level 2","position":"2"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-3/"},"name":"Level 3","position":"3"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-4/"},"name":"Level 4","position":"4"}]}';
        self::assertCount(1, $this->event->getAdditionalTypes());
        self::assertSame($expected, $this->renderJsonLd($this->event->getAdditionalTypes()[0]));
    }

    /**
     * @test
     */
    public function rootLineWithDifferentWebPageTypeSet(): void
    {
        $this->setAutomaticBreadcrumbSchemaGenerationConfigurationSetting(true);
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

        $this->subject->__invoke($this->event);

        $expected = '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}';
        self::assertCount(1, $this->event->getAdditionalTypes());
        self::assertSame($expected, $this->renderJsonLd($this->event->getAdditionalTypes()[0]));
    }
}
