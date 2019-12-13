<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Hooks\PageRenderer;

use Brotkrueml\Schema\Aspect\AspectInterface;
use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @runTestsInSeparateProcesses
 */
class SchemaMarkupInjectionTest extends TestCase
{
    /**
     * @var SchemaMarkupInjection
     */
    protected $subject;

    /**
     * @var MockObject|PageRenderer
     */
    protected $pageRendererMock;

    /**
     * @var MockObject|ExtensionConfiguration
     */
    protected $extensionConfigurationMock;

    /**
     * @var MockObject|TypoScriptFrontendController
     */
    protected $controllerMock;

    /**
     * @var MockObject|FrontendInterface
     */
    private $cacheMock;

    public static function setUpBeforeClass(): void
    {
        if (!\defined('TYPO3_version')) {
            $_EXTKEY = 'core';
            include __DIR__ . '/../../../../.Build/web/typo3/sysext/' . $_EXTKEY . '/ext_emconf.php';
            \define('TYPO3_version', \array_pop($EM_CONF)['version']);
        }
    }

    protected function setUp(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $this->controllerMock->newHash = 'somehash';
        $this->controllerMock->page = ['no_index' => 0, 'uid' => 42];

        $this->extensionConfigurationMock = $this->createMock(ExtensionConfiguration::class);

        $this->cacheMock = $this->createMock(FrontendInterface::class);
        $this->cacheMock
            ->expects(self::any())
            ->method('get')
            ->willReturn(null);
        $this->cacheMock
            ->expects(self::any())
            ->method('set');

        $this->subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            GeneralUtility::makeInstance(SchemaManager::class),
            $this->cacheMock
        );

        $this->pageRendererMock = $this->createMock(PageRenderer::class);
    }

    /**
     * @test
     */
    public function executeInBackendModeDoesNothing()
    {
        \define('TYPO3_MODE', 'BE');

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $params = [];
        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithoutDefinedMarkupAndNoAspectsDoesNotEmbedAnything()
    {
        \define('TYPO3_MODE', 'FE');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $this->setSeoExtensionInstallationState(false);

        $params = [];
        $this->subject->addAspect($this->getDummyAspectMock());
        $this->subject->execute($params, $this->pageRendererMock);
    }

    private function getDummyAspectMock(): AspectInterface
    {
        $dummyAspectMock = $this->createMock(AspectInterface::class);
        $dummyAspectMock
            ->expects(self::any())
            ->method('execute');

        return $dummyAspectMock;
    }

    /**
     * @test
     */
    public function executeWithMarkupDefinedCallsAddHeaderDataIfShouldEmbeddedIntoHead(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupInBodySection' => '0']);

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $schemaManager,
            $this->cacheMock
        );

        $params = [];
        $subject->addAspect($this->getDummyAspectMock());
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddFooterDataOnceIfShouldEmbeddedIntoBody(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupInBodySection' => '1']);

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addFooterData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>');

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            GeneralUtility::makeInstance(SchemaManager::class),
            $this->cacheMock
        );

        $params = [];
        $subject->addAspect($this->getDummyAspectMock());
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsNotInstalledAddsHeaderData(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(false);

        $controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $controllerMock->page = ['uid' => 42];

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupInBodySection' => '0']);

        $subject = new SchemaMarkupInjection(
            $controllerMock,
            $this->extensionConfigurationMock,
            null,
            $this->cacheMock
        );

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>');

        $params = [];
        $subject->addAspect($this->getDummyAspectMock());
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsInstalledAndNoIndexIsSetNoHeaderDataIsEmbedded(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $controllerMock->page = ['no_index' => 1];

        $subject = new SchemaMarkupInjection(
            $controllerMock,
            $this->extensionConfigurationMock,
            null,
            $this->cacheMock
        );

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $params = [];
        $subject->addAspect($this->getDummyAspectMock());
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function givenAspectIsCalled(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $aspectMock = $this->createMock(AspectInterface::class);
        $aspectMock
            ->expects(self::once())
            ->method('execute');

        $params = [];
        $this->subject->addAspect($aspectMock);
        $this->subject->execute($params, $this->pageRendererMock);
    }

    protected function setSeoExtensionInstallationState(bool $state): void
    {
        /** @var MockObject|PackageManager $packageManagerMock */
        $packageManagerMock = $this->createMock(PackageManager::class);
        $packageManagerMock
            ->expects(self::once())
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn($state);

        ExtensionManagementUtility::setPackageManager($packageManagerMock);
    }

    /**
     * @test
     */
    public function whenCacheIDefinedItIsUsedToGetMarkup(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $cacheMock = $this->createMock(FrontendInterface::class);
        $cacheMock
            ->expects(self::once())
            ->method('get')
            ->willReturn('some-cached-markup');

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('some-cached-markup');

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            null,
            $cacheMock
        );

        $params = [];
        $subject->addAspect($this->getDummyAspectMock());
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenCacheIsDefinedItIsUsedToStoreMarkup(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $cacheMock = $this->createMock(FrontendInterface::class);
        $cacheMock
            ->expects(self::once())
            ->method('get')
            ->willReturn(false);
        $cacheMock
            ->expects(self::once())
            ->method('set')
            ->with(
                self::anything(),
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>',
                self::anything(),
                self::anything()
            );

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $schemaManager,
            $cacheMock
        );

        $params = [];
        $subject->addAspect($this->getDummyAspectMock());
        $subject->execute($params, $this->pageRendererMock);
    }
}
