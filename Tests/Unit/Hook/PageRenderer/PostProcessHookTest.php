<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Hook\PageRenderer;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Hook\PageRenderer\PostProcessHook;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Unit\Helper\LogManagerMockTrait;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @runTestsInSeparateProcesses
 */
class PostProcessHookTest extends UnitTestCase
{
    use LogManagerMockTrait;

    protected $resetSingletonInstances = true;

    /**
     * @var PostProcessHook
     */
    protected $postProcessHook;

    /**
     * @var MockObject|PageRenderer
     */
    protected $pageRendererMock;

    public function setUp(): void
    {
        $this->initialiseLogManagerMock();

        $this->postProcessHook = new PostProcessHook();

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->pageRendererMock = $this->getMockBuilder(PageRenderer::class)
            ->disableOriginalConstructor()
            ->setMethods(['addHeaderData'])
            ->getMock();
    }

    /**
     * @test
     */
    public function executeWithoutSchemaDoesNotCallAddHeaderData(): void
    {
        \define('TYPO3_MODE', 'FE');

        $this->pageRendererMock
            ->expects($this->never())
            ->method('addHeaderData');

        $params = [];

        $this->postProcessHook->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddHeaderDataOnce(): void
    {
        \define('TYPO3_MODE', 'FE');

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new Thing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects($this->once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","name":"some name"}</script>');

        $this->postProcessHook->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeInBackendModeDoesNothing()
    {
        \define('TYPO3_MODE', 'BE');

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType((new Thing())->setProperty('name', 'some name'));

        $this->pageRendererMock
            ->expects($this->never())
            ->method('addHeaderData');

        $params = [];

        $this->postProcessHook->execute($params, $this->pageRendererMock);
    }
}
