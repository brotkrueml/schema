<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Hooks\PageRenderer;

use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @runTestsInSeparateProcesses
 */
class SchemaMarkupInjectionTest extends TestCase
{
    use SchemaCacheTrait;

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

    /**
     * @var MockObject|ObjectManager
     */
    private $objectManagerMock;

    /**
     * @var MockObject|Dispatcher
     */
    private $signalSlotDispatcherMock;

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

        $this->signalSlotDispatcherMock = $this->createMock(Dispatcher::class);

        $this->objectManagerMock = $this->createMock(ObjectManager::class);
        $this->objectManagerMock
            ->expects(self::any())
            ->method('get')
            ->with(Dispatcher::class)
            ->willReturn($this->signalSlotDispatcherMock);

        GeneralUtility::setSingletonInstance(ObjectManager::class, $this->objectManagerMock);

        $this->defineCacheStubsWhichReturnEmptyEntry();
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function executeInBackendModeDoesNothing()
    {
        $this->defineConstants('9.5', 'BE');
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
        $this->defineConstants('9.5', 'FE');
        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $this->setSeoExtensionInstallationState(false);

        $params = [];
        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithMarkupDefinedCallsAddHeaderDataIfShouldEmbeddedIntoHead(): void
    {
        $this->defineConstants('9.5', 'FE');
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
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddFooterDataOnceIfShouldEmbeddedIntoBody(): void
    {
        $this->defineConstants('9.5', 'FE');
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
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsNotInstalledAddsHeaderData(): void
    {
        $this->defineConstants('9.5', 'FE');
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
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsInstalledAndNoIndexIsSetNoHeaderDataIsEmbedded(): void
    {
        $this->defineConstants('9.5', 'FE');
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
        $subject->execute($params, $this->pageRendererMock);
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
        $this->defineConstants('9.5', 'FE');
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
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenCacheIsDefinedItIsUsedToStoreMarkup(): void
    {
        $this->defineConstants('9.5', 'FE');
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
        $subject->execute($params, $this->pageRendererMock);
    }

    private function defineConstants(string $version, string $mode): void
    {
        \define('TYPO3_branch', $version);
        \define('TYPO3_MODE', $mode);
    }
}
