<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Hook\PageRenderer;

use Brotkrueml\Schema\Hook\PageRenderer\PostProcessHook;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
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

    public function setUp(): void
    {
        $typoScriptFrontendControllerMock = $this->createMock(TypoScriptFrontendController::class);
        $typoScriptFrontendControllerMock->page = ['no_index' => 0];

        $this->subject = new PostProcessHook($typoScriptFrontendControllerMock);

        $this->pageRendererMock = $this->createMock(PageRenderer::class);
    }

    /**
     * @test
     */
    public function executeWithoutSchemaDoesNotCallAddHeaderData(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $this->pageRendererMock
            ->expects($this->never())
            ->method('addHeaderData');

        $params = [];

        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddHeaderDataOnce(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->setSeoExtensionInstallationState(true);

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new FixtureThing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects($this->once())
            ->method('addHeaderData')
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

        $typoScriptFrontendControllerMock = $this->createMock(TypoScriptFrontendController::class);
        $typoScriptFrontendControllerMock->page = ['no_index' => 1];

        $subject = new PostProcessHook($typoScriptFrontendControllerMock);

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
