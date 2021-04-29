<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Hooks\PageRenderer;

use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Compatibility\Compatibility;
use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Aspect\TestAspect;
use Brotkrueml\Schema\Tests\Fixtures\Aspect\WrongAspect;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class SchemaMarkupInjectionWithAspectTest extends TestCase
{
    use SchemaCacheTrait;

    /**
     * @var Stub|PageRenderer
     */
    protected $pageRendererStub;

    /**
     * @var Stub|ExtensionConfiguration
     */
    protected $extensionConfigurationStub;

    /**
     * @var Stub|TypoScriptFrontendController
     */
    protected $controllerStub;

    /**
     * @var Stub|PagesCacheService
     */
    private $pagesCacheServiceStub;

    /**
     * @var Stub|EventDispatcher
     */
    private $eventDispatcherStub;

    protected function setUp(): void
    {
        $this->controllerStub = $this->createStub(TypoScriptFrontendController::class);
        $this->controllerStub->newHash = 'somehash';
        $this->controllerStub->page = ['no_index' => 0, 'uid' => 42];

        $this->extensionConfigurationStub = $this->createStub(ExtensionConfiguration::class);

        $this->pagesCacheServiceStub = $this->createStub(PagesCacheService::class);

        if ((new Compatibility())->isPsr14EventDispatcherAvailable()) {
            $this->eventDispatcherStub = $this->createStub(EventDispatcher::class);
            $this->eventDispatcherStub
                ->method('dispatch')
                ->with(self::anything())
                ->willReturn(new ShouldEmbedMarkupEvent([], true));
        }

        $this->pageRendererStub = $this->createStub(PageRenderer::class);

        /** @var MockObject|PackageManager $packageManagerStub */
        $packageManagerStub = $this->createStub(PackageManager::class);
        $packageManagerStub
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn(false);

        ExtensionManagementUtility::setPackageManager($packageManagerStub);

        $this->defineCacheStubsWhichReturnEmptyEntry();
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::execute
     * @covers \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::getRegisteredAspects
     */
    public function givenAspectIsCalled(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect']['test']
            = TestAspect::class;

        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::once())
            ->method('addType')
            ->with(new Thing());

        $subject = new SchemaMarkupInjection(
            $this->controllerStub,
            $this->extensionConfigurationStub,
            $schemaManagerMock,
            $this->pagesCacheServiceStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererStub);
    }

    /**
     * @test
     */
    public function registeredAspectDoesNotImplementAspectInterfaceThenExceptionIsThrown(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1583429697);
        $this->expectExceptionMessage('Aspect "Brotkrueml\Schema\Tests\Fixtures\Aspect\WrongAspect" must implement interface "Brotkrueml\Schema\Aspect\AspectInterface"');

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect']['test']
            = WrongAspect::class;

        $schemaManagerStub = $this->createStub(SchemaManager::class);

        $subject = new SchemaMarkupInjection(
            $this->controllerStub,
            $this->extensionConfigurationStub,
            $schemaManagerStub,
            $this->pagesCacheServiceStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererStub);
    }
}
