<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Middleware;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Middleware\BreadcrumbList;
use Brotkrueml\Schema\Tests\Unit\Helper\TypeFixtureNamespace;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BreadcrumbListTest extends UnitTestCase
{
    use TypeFixtureNamespace;

    protected $resetSingletonInstances = true;

    /** @var MockObject|TypoScriptFrontendController */
    protected $controllerMock;

    /** @var MockObject|ServerRequestInterface */
    protected $requestMock;

    /** @var MockObject|RequestHandlerInterface */
    protected $handlerMock;

    /** @var MockObject|ContentObjectRenderer */
    protected $contentObjectRendererMock;

    /**
     * @test
     */
    public function automaticBreadcrumbListGenerationIsDeactivated(): void
    {
        $this->setUpGeneralMocks();

        /** @var MockObject|ExtensionConfiguration $configurationMock */
        $configurationMock = $this->createMock(ExtensionConfiguration::class);
        $configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'automaticBreadcrumbSchemaGeneration')
            ->willReturn(false);

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects($this->never())
            ->method('addType');

        (new BreadcrumbList($this->controllerMock, $schemaManagerMock, $configurationMock, $this->contentObjectRendererMock))
            ->process($this->requestMock, $this->handlerMock);
    }

    protected function setUpGeneralMocks(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);

        $this->contentObjectRendererMock = $this->createMock(ContentObjectRenderer::class);

        $this->requestMock = $this->createMock(ServerRequestInterface::class);

        $this->handlerMock = $this->createMock(RequestHandlerInterface::class);
        $this->handlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->requestMock);
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
            ->expects($this->never())
            ->method('addType');

        (new BreadcrumbList(
            $this->controllerMock,
            $schemaManagerMock,
            $this->getExtensionConfigurationMockWithGetReturnTrue(),
            $this->contentObjectRendererMock
        ))
            ->process($this->requestMock, $this->handlerMock);
    }

    /**
     * @return MockObject|ExtensionConfiguration
     */
    private function getExtensionConfigurationMockWithGetReturnTrue()
    {
        $configurationMock = $this->createMock(ExtensionConfiguration::class);
        $configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'automaticBreadcrumbSchemaGeneration')
            ->willReturn(true);

        return $configurationMock;
    }

    public function rootLineProvider(): array
    {
        return [
            'Rootline with web page type set' => [
                [
                    2 => [
                        'uid' => 2,
                        'title' => 'A page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '0',
                        'tx_schema_webpagetype' => 'ItemPage',
                    ],
                    1 => [
                        'uid' => 1,
                        'title' => 'Site root page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '1',
                        'tx_schema_webpagetype' => '',
                    ],
                ],
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>',
            ],
            'Rootline with nav_title set' => [
                [
                    2 => [
                        'uid' => 2,
                        'title' => 'A page',
                        'nav_title' => 'A nav title page',
                        'nav_hide' => '0',
                        'is_siteroot' => '0',
                        'tx_schema_webpagetype' => '',
                    ],
                    1 => [
                        'uid' => 1,
                        'title' => 'Site root page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '1',
                        'tx_schema_webpagetype' => '',
                    ],
                ],
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A nav title page","position":"1"}}</script>',
            ],
            'Rootline with nav_hide set' => [
                [
                    3 => [
                        'uid' => 3,
                        'title' => 'A page',
                        'nav_title' => '',
                        'nav_hide' => '1',
                        'is_siteroot' => '0',
                        'tx_schema_webpagetype' => '',
                    ],
                    2 => [
                        'uid' => 2,
                        'title' => 'A page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '0',
                        'tx_schema_webpagetype' => '',
                    ],
                    1 => [
                        'uid' => 1,
                        'title' => 'Site root page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '1',
                        'tx_schema_webpagetype' => '',
                    ],
                ],
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>',
            ],
            'Rootline with siteroot not on first level' => [
                [
                    2 => [
                        'uid' => 2,
                        'title' => 'A page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '0',
                        'tx_schema_webpagetype' => '',
                    ],
                    1 => [
                        'uid' => 1,
                        'title' => 'Site root page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '1',
                        'tx_schema_webpagetype' => '',
                    ],
                    0 => [
                        'uid' => 42,
                        'title' => 'some other page',
                        'nav_title' => '',
                        'nav_hide' => '0',
                        'is_siteroot' => '0',
                        'tx_schema_webpagetype' => '',
                    ],
                ],
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/the-page/"},"name":"A page","position":"1"}}</script>',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider rootLineProvider
     *
     * @param array $rootLine
     * @param string $expected
     */
    public function breadCrumbIsGeneratedCorrectly(
        array $rootLine,
        string $expected
    ): void {
        $this->setUpGeneralMocks();

        $this->controllerMock->rootLine = $rootLine;

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $this->contentObjectRendererMock
            ->expects($this->once())
            ->method('typoLink_URL')
            ->with([
                'parameter' => '2',
                'forceAbsoluteUrl' => true,
            ])
            ->willReturn('https://example.org/the-page/');

        $subject = new BreadcrumbList(
            $this->controllerMock,
            $schemaManager,
            $this->getExtensionConfigurationMockWithGetReturnTrue(),
            $this->contentObjectRendererMock
        );

        $subject->process($this->requestMock, $this->handlerMock);

        $this->assertSame($expected, $schemaManager->renderJsonLd());
    }
}
