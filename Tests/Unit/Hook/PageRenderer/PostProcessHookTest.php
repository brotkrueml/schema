<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Hook\PageRenderer;

use Brotkrueml\Schema\Hook\PageRenderer\PostProcessHook;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @runTestsInSeparateProcesses
 */
class PostProcessHookTest extends TestCase
{
    /**
     * @var PostProcessHook
     */
    protected $subject;

    /**
     * @var MockObject|PageRenderer
     */
    protected $pageRendererMock;

    /**
     * @var MockObject|ExtensionConfiguration
     */
    protected $configurationMock;

    public function setUp(): void
    {
        $controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $controllerMock->page = ['no_index' => 0];

        $this->configurationMock = $this->createMock(ExtensionConfiguration::class);

        $this->subject = new PostProcessHook($controllerMock, $this->configurationMock);

        $this->pageRendererMock = $this->createMock(PageRenderer::class);
    }

    /**
     * @test
     */
    public function executeWithoutSchemaDoesNotEmbedMarkup(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $this->pageRendererMock
            ->expects($this->never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects($this->never())
            ->method('addFooterData');

        $params = [];

        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddHeaderDataOnceIfEmbeddedIntoHead(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'embedMarkupInBodySection')
            ->willReturn(false);

        $this->pageRendererMock
            ->expects($this->once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>');

        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddFooterDataOnceIfEmbeddedIntoBody(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'embedMarkupInBodySection')
            ->willReturn(true);

        $this->pageRendererMock
            ->expects($this->once())
            ->method('addFooterData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>');

        $this->subject->execute($params, $this->pageRendererMock);
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
            ->expects($this->never())
            ->method('addHeaderData');

        $params = [];

        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsNotInstalledAddsHeaderData(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(false);

        $controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $controllerMock->page = ['no_index' => 1];

        $this->configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'embedMarkupInBodySection')
            ->willReturn(false);

        $subject = new PostProcessHook($controllerMock, $this->configurationMock);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects($this->once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"FixtureThing","name":"some name"}</script>');

        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsInstalledAndNoIndexIsSetNoHeaderDataIsEmbedded(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $typoScriptFrontendControllerMock = $this->createMock(TypoScriptFrontendController::class);
        $typoScriptFrontendControllerMock->page = ['no_index' => 1];

        $subject = new PostProcessHook($typoScriptFrontendControllerMock);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects($this->never())
            ->method('addHeaderData');

        $subject->execute($params, $this->pageRendererMock);
    }

    protected function setSeoExtensionInstallationState(bool $state): void
    {
        /** @var MockObject|PackageManager $packageManagerMock */
        $packageManagerMock = $this->createMock(PackageManager::class);
        $packageManagerMock
            ->expects($this->once())
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn($state);

        ExtensionManagementUtility::setPackageManager($packageManagerMock);
    }
}
