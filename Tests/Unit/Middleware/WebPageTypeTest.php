<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Middleware;

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Middleware\WebPageType;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\ItemPage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\WebPage;
use Brotkrueml\Schema\Tests\Unit\Helper\TypeFixtureNamespace;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class WebPageTypeTest extends UnitTestCase
{
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
        parent::setUpBeforeClass();
        static::setTypeNamespaceToFixtureNamespace();
    }

    public static function tearDownAfterClass(): void
    {
        static::restoreOriginalTypeNamespace();
        parent::tearDownAfterClass();
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::__construct
     */
    public function constructWorksCorrectlyWithNoParametersGiven(): void
    {
        $GLOBALS['TSFE'] = 'fake controller';

        /** @noinspection PhpUnhandledExceptionInspection */
        $reflector = new \ReflectionClass(WebPageType::class);

        /** @noinspection PhpUnhandledExceptionInspection */
        $controller = $reflector->getProperty('controller');
        $controller->setAccessible(true);

        /** @noinspection PhpUnhandledExceptionInspection */
        $schemaManager = $reflector->getProperty('schemaManager');
        $schemaManager->setAccessible(true);

        /** @noinspection PhpUnhandledExceptionInspection */
        $configuration = $reflector->getProperty('configuration');
        $configuration->setAccessible(true);

        $subject = new WebPageType();

        self::assertSame('fake controller', $controller->getValue($subject));
        self::assertInstanceOf(SchemaManager::class, $schemaManager->getValue($subject));
        self::assertInstanceOf(ExtensionConfiguration::class, $configuration->getValue($subject));

        unset($GLOBALS['TSFE']);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function automaticWebPageGenerationIsDeactivated()
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

        (new WebPageType($this->controllerMock, $schemaManagerMock, $configurationMock))
            ->process($this->requestMock, $this->handlerMock);
    }

    protected function setUpGeneralMocks(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);

        $this->requestMock = $this->createMock(ServerRequestInterface::class);

        $this->handlerMock = $this->createMock(RequestHandlerInterface::class);
        $this->handlerMock
            ->expects(self::once())
            ->method('handle')
            ->with($this->requestMock);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::process
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

        (new WebPageType(
            $this->controllerMock,
            $schemaManagerMock,
            $this->getExtensionConfigurationMockWithGetReturnTrue()
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
            ->expects(self::once())
            ->method('get')
            ->with('schema', 'automaticWebPageSchemaGeneration')
            ->willReturn(true);

        return $configurationMock;
    }

    public function pagePropertiesProvider(): iterable
    {
        yield 'Type is empty, so WebPage is used' => [
            [
                'tx_schema_webpagetype' => '',
                'title' => 'A test title',
                'description' => 'A test description',
                'endtime' => 0,
            ],
            (new WebPage())
        ];

        yield 'Type is set, so this type is used' => [
            [
                'tx_schema_webpagetype' => 'ItemPage',
                'title' => 'An item title',
                'description' => 'An item description',
                'endtime' => 0,
            ],
            (new ItemPage())
        ];

        yield 'Endtime is defined, expires is set' => [
            [
                'tx_schema_webpagetype' => 'WebPage',
                'title' => 'An item title',
                'description' => 'An item description',
                'endtime' => 1561672753,
            ],
            (new WebPage())->setProperty('expires', '2019-06-27T21:59:13+00:00')
        ];
    }

    /**
     * @test
     * @dataProvider pagePropertiesProvider
     *
     * @param array $pageProperties
     * @param AbstractType $expectedWebPage
     * @covers       \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function withNotAlreadyAssignedWebPageModelPropertiesFromTsfeAreSet(
        array $pageProperties,
        AbstractType $expectedWebPage
    ): void {
        $this->setUpGeneralMocks();

        $this->controllerMock->page = $pageProperties;

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->createMock(SchemaManager::class);
        $schemaManagerMock
            ->expects(self::once())
            ->method('addType')
            ->with($expectedWebPage);

        $subject = new WebPageType(
            $this->controllerMock,
            $schemaManagerMock,
            $this->getExtensionConfigurationMockWithGetReturnTrue()
        );

        $subject->process($this->requestMock, $this->handlerMock);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function whenTypeDoesNotExistNoWebPageIsSet(): void
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

        (new WebPageType(
            $this->controllerMock,
            $schemaManagerMock,
            $this->getExtensionConfigurationMockWithGetReturnTrue()
        ))
            ->process($this->requestMock, $this->handlerMock);
    }
}
