<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Aspect;

use Brotkrueml\Schema\Aspect\BreadcrumbListAspect;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BreadcrumbListAspectTest extends UnitTestCase
{
    use SchemaCacheTrait;

    protected $resetSingletonInstances = true;

    /** @var MockObject|TypoScriptFrontendController */
    protected $controllerMock;

    /** @var MockObject|ServerRequestInterface */
    protected $requestMock;

    /** @var MockObject|RequestHandlerInterface */
    protected $handlerMock;

    /** @var MockObject|ContentObjectRenderer */
    protected $contentObjectRendererMock;

    /** @var Stub|TypeRegistry */
    private $typeRegistryStub;

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
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function automaticBreadcrumbListGenerationIsDeactivated(): void
    {
        $this->setUpGeneralMocks();

        /** @var MockObject|ExtensionConfiguration $configurationMock */
        $configurationMock = $this->createMock(ExtensionConfiguration::class);
        $configurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema', 'automaticBreadcrumbSchemaGeneration')
            ->willReturn(false);

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::never())
            ->method('addType');

        (new BreadcrumbListAspect(
            $this->controllerMock,
            $configurationMock,
            $this->contentObjectRendererMock
        ))
            ->execute($schemaManagerMock);
    }

    protected function setUpGeneralMocks(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $this->contentObjectRendererMock = $this->createMock(ContentObjectRenderer::class);
    }

    /**
     * @test
     */
    public function withActivatedConfigurationOptionAndEmptyRootlineNoMarkupIsGenerated(): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->rootLine = [];

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::never())
            ->method('addType');

        (new BreadcrumbListAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue(),
            $this->contentObjectRendererMock
        ))
            ->execute($schemaManagerMock);
    }

    /**
     * @return MockObject|ExtensionConfiguration
     */
    private function getExtensionConfigurationMockWithGetReturnsTrue()
    {
        $configurationMock = $this->createMock(ExtensionConfiguration::class);
        $configurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema', 'automaticBreadcrumbSchemaGeneration')
            ->willReturn(true);

        return $configurationMock;
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A nav title page","position":"1"}}</script>',
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>',
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>',
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>',
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page with doktype 198","position":"1"}}</script>',
        ];
    }

    /**
     * @test
     * @dataProvider rootLineProvider
     *
     * @param array $rootLine
     * @param string $expected
     */
    public function breadCrumbIsGeneratedCorrectly(array $rootLine, string $expected): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->rootLine = $rootLine;

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $this->contentObjectRendererMock
            ->expects(self::once())
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/the-page/');

        $subject = new BreadcrumbListAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue(),
            $this->contentObjectRendererMock
        );

        $subject->execute($schemaManager);

        self::assertSame($expected, $schemaManager->renderJsonLd());
    }

    /**
     * @test
     */
    public function breadCrumbIsSortedCorrectly(): void
    {
        $this->setUpGeneralMocks();

        $this->contentObjectRendererMock
            ->expects(self::at(0))
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/level-1/');

        $this->contentObjectRendererMock
            ->expects(self::at(1))
            ->method('typoLink_URL')
            ->with([
                'parameter' => '33',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/level-2/');

        $this->contentObjectRendererMock
            ->expects(self::at(2))
            ->method('typoLink_URL')
            ->with([
                'parameter' => '22',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/level-3/');

        $this->contentObjectRendererMock
            ->expects(self::at(3))
            ->method('typoLink_URL')
            ->with([
                'parameter' => '111',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/level-4/');

        $this->controllerMock->rootLine = [
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

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $subject = new BreadcrumbListAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue(),
            $this->contentObjectRendererMock
        );

        $subject->execute($schemaManager);

        self::assertSame(
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-1/"},"name":"Level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-2/"},"name":"Level 2","position":"2"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-3/"},"name":"Level 3","position":"3"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/level-4/"},"name":"Level 4","position":"4"}]}</script>',
            $schemaManager->renderJsonLd()
        );
    }

    /**
     * @test
     */
    public function rootlineWithDifferentWebPageTypeSet(): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->rootLine = [
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

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $this->contentObjectRendererMock
            ->expects(self::once())
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/the-page/');

        $subject = new BreadcrumbListAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue(),
            $this->contentObjectRendererMock
        );

        $subject->execute($schemaManager);

        $expected = '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>';

        self::assertSame($expected, $schemaManager->renderJsonLd());
    }
}
