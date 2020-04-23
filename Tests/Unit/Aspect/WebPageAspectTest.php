<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Aspect;

use Brotkrueml\Schema\Aspect\WebPageAspect;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class WebPageAspectTest extends TestCase
{
    use SchemaCacheTrait;

    protected $resetSingletonInstances = true;

    /** @var MockObject|TypoScriptFrontendController */
    protected $controllerMock;

    /** @var MockObject|ServerRequestInterface */
    protected $requestMock;

    /** @var MockObject|RequestHandlerInterface */
    protected $handlerMock;

    /** @var Stub|TypeRegistry */
    private $typeRegistryStub;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $typeRegistryStub = $this->createStub(TypeRegistry::class);
        $map = [
            ['ItemPage', FixtureType\ItemPage::class],
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
     *
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::__construct
     */
    public function constructWorksCorrectlyWithNoParametersAreGiven(): void
    {
        $GLOBALS['TSFE'] = 'fake controller';

        $reflector = new \ReflectionClass(WebPageAspect::class);

        /** @noinspection PhpUnhandledExceptionInspection */
        $controller = $reflector->getProperty('controller');
        $controller->setAccessible(true);

        /** @noinspection PhpUnhandledExceptionInspection */
        $configuration = $reflector->getProperty('configuration');
        $configuration->setAccessible(true);

        $packageManagerStub = $this->createStub(PackageManager::class);
        $packageManagerStub
            ->method('getActivePackages')
            ->willReturn([]);

        GeneralUtility::setSingletonInstance(PackageManager::class, $packageManagerStub);

        $cacheFrontendStub = $this->createStub(FrontendInterface::class);
        $cacheFrontendStub
            ->method('get')
            ->willReturn([]);

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with(Extension::CACHE_CORE_IDENTIFIER)
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        $subject = new WebPageAspect();

        self::assertSame('fake controller', $controller->getValue($subject));
        self::assertInstanceOf(ExtensionConfiguration::class, $configuration->getValue($subject));

        unset($GLOBALS['TSFE']);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::execute
     */
    public function whenAutomaticWebPageGenerationIsDeactivatedNoTypeIsAdded()
    {
        $this->setUpGeneralMocks();

        /** @var MockObject|ExtensionConfiguration $configurationMock */
        $configurationMock = $this->createMock(ExtensionConfiguration::class);
        $configurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema', 'automaticWebPageSchemaGeneration')
            ->willReturn(false);

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::never())
            ->method('hasWebPage');

        (new WebPageAspect(
            $this->controllerMock,
            $configurationMock
        ))
            ->execute($schemaManagerMock);
    }

    protected function setUpGeneralMocks(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::execute
     */
    public function withAssignedWebPageModelRequestIsDirectlyPassedOverToNextMiddleware(): void
    {
        $this->setUpGeneralMocks();

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::once())
            ->method('hasWebPage')
            ->willReturn(true);

        (new WebPageAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue()
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
            ->with('schema', 'automaticWebPageSchemaGeneration')
            ->willReturn(true);

        return $configurationMock;
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::execute
     */
    public function pagePropertyForWebPageTypeIsEmptyThenWebPageIsUsed(): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->page = [
            'tx_schema_webpagetype' => '',
            'title' => 'A test title',
            'description' => 'A test description',
            'endtime' => 0,
        ];

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::once())
            ->method('addType')
            ->with(new FixtureType\WebPage());

        $subject = new WebPageAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue()
        );

        $subject->execute($schemaManagerMock);
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::execute
     */
    public function pagePropertyForWebPageTypeIsSetThenThisTypeIsUsed(): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->page = [
            'tx_schema_webpagetype' => 'ItemPage',
            'title' => 'An item title',
            'description' => 'An item description',
            'endtime' => 0,
        ];

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::once())
            ->method('addType')
            ->with(new FixtureType\ItemPage());

        $subject = new WebPageAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue()
        );

        $subject->execute($schemaManagerMock);
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::execute
     */
    public function pagePropertyForEndtimeIsSetThenExpiresPropertyIsSet(): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->page = [
            'tx_schema_webpagetype' => 'WebPage',
            'title' => 'An item title',
            'description' => 'An item description',
            'endtime' => 1561672753,
        ];

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::once())
            ->method('addType')
            ->with((new FixtureType\WebPage())->setProperty('expires', '2019-06-27T21:59:13+00:00'));

        $subject = new WebPageAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue()
        );

        $subject->execute($schemaManagerMock);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Aspect\WebPageAspect::execute
     */
    public function whenTypeDoesNotExistsNoWebPageIsSet(): void
    {
        $this->setUpGeneralMocks();

        $this->controllerMock->page = [
            'tx_schema_webpagetype' => 'TypeDoesNotExist',
        ];

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::never())
            ->method('addType');

        (new WebPageAspect(
            $this->controllerMock,
            $this->getExtensionConfigurationMockWithGetReturnsTrue()
        ))
            ->execute($schemaManagerMock);
    }
}
