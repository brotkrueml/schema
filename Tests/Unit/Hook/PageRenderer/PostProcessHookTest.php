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
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        $this->subject = new PostProcessHook();
        $this->pageRendererMock = $this->createMock(PageRenderer::class);
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

        $this->subject->execute($params, $this->pageRendererMock);
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

        $this->subject->execute($params, $this->pageRendererMock);
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

        $this->subject->execute($params, $this->pageRendererMock);
    }
}
