<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Aspect;

use Brotkrueml\Schema\Aspect\WebPageAspect;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\ItemPage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\WebPage;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Unit\Helper\TypeFixtureNamespace;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class WebPageAspectTest extends TestCase
{
    use SchemaCacheTrait;
    use TypeFixtureNamespace;

    protected $resetSingletonInstances = true;

    /** @var MockObject|TypoScriptFrontendController */
    protected $controllerMock;

    /** @var MockObject|ServerRequestInterface */
    protected $requestMock;

    /** @var MockObject|RequestHandlerInterface */
    protected $handlerMock;

    public static function setUpBeforeClass(): void
    {
        static::setTypeNamespaceToFixtureNamespace();
    }

    public static function tearDownAfterClass(): void
    {
        static::restoreOriginalTypeNamespace();
    }

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();
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

        (new WebPageAspect($this->controllerMock, $configurationMock))
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
            ->with(new WebPage());

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
            ->with(new ItemPage());

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
            ->with((new WebPage())->setProperty('expires', '2019-06-27T21:59:13+00:00'));

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
