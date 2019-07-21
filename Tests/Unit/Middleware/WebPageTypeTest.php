<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Middleware;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Middleware\WebPageType;
use Brotkrueml\Schema\Model\Type\ItemPage;
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Tests\Unit\Helper\LogManagerMockTrait;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class WebPageTypeTest extends UnitTestCase
{
    use LogManagerMockTrait;

    protected $resetSingletonInstances = true;

    /** @var MockObject|TypoScriptFrontendController */
    protected $controllerMock;

    /** @var MockObject|ServerRequestInterface */
    protected $requestMock;

    /** @var MockObject|RequestHandlerInterface */
    protected $handlerMock;

    public function setUp(): void
    {
        $this->initialiseLogManagerMock();
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

        $webPageType = new WebPageType();

        $this->assertSame('fake controller', $controller->getValue($webPageType));
        $this->assertInstanceOf(SchemaManager::class, $schemaManager->getValue($webPageType));
        $this->assertInstanceOf(ExtensionConfiguration::class, $configuration->getValue($webPageType));

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
        $configurationMock = $this->getMockBuilder(ExtensionConfiguration::class)
            ->setMethods(['get'])
            ->getMock();

        $configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'automaticWebPageSchemaGeneration')
            ->willReturn(false);

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['hasWebPage'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->never())
            ->method('hasWebPage');

        (new WebPageType($this->controllerMock, $schemaManagerMock, $configurationMock))
            ->process($this->requestMock, $this->handlerMock);
    }

    protected function setUpGeneralMocks(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);

        $this->requestMock = $this->createMock(ServerRequestInterface::class);

        $this->handlerMock = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $this->handlerMock
            ->expects($this->once())
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
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['hasWebPage'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->once())
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
        $configurationMock = $this->getMockBuilder(ExtensionConfiguration::class)
            ->setMethods(['get'])
            ->getMock();

        $configurationMock
            ->expects($this->once())
            ->method('get')
            ->with('schema', 'automaticWebPageSchemaGeneration')
            ->willReturn(true);

        return $configurationMock;
    }

    public function pagePropertiesProvider(): array
    {
        $this->initialiseLogManagerMock();

        return [
            'Type is empty, so WebPage is used' => [
                [
                    'tx_schema_webpagetype' => '',
                    'title' => 'A test title',
                    'description' => 'A test description',
                    'endtime' => 0,
                ],
                (new WebPage())
            ],
            'Type is set, so this type is used' => [
                [
                    'tx_schema_webpagetype' => 'ItemPage',
                    'title' => 'An item title',
                    'description' => 'An item description',
                    'endtime' => 0,
                ],
                (new ItemPage())
            ],
            'Endtime is defined, expires is set' => [
                [
                    'tx_schema_webpagetype' => 'WebPage',
                    'title' => 'An item title',
                    'description' => 'An item description',
                    'endtime' => 1561672753,
                ],
                (new WebPage())->setProperty('expires', '2019-06-27T21:59:13+00:00')
            ],
        ];
    }

    /**
     * @test
     * @dataProvider pagePropertiesProvider
     *
     * @param array $pageProperties
     * @param AbstractType $expectedWebPage
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function withNotAlreadyAssignedWebPageModelPropertiesFromTsfeAreSet(
        array $pageProperties,
        AbstractType $expectedWebPage
    ): void {
        $this->setUpGeneralMocks();

        $this->controllerMock->page = $pageProperties;

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['addType'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->once())
            ->method('addType')
            ->with($expectedWebPage);

        $webPageType = new WebPageType(
            $this->controllerMock,
            $schemaManagerMock,
            $this->getExtensionConfigurationMockWithGetReturnTrue()
        );

        $webPageType->process($this->requestMock, $this->handlerMock);
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
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['addType'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->never())
            ->method('addType');

        (new WebPageType(
            $this->controllerMock,
            $schemaManagerMock,
            $this->getExtensionConfigurationMockWithGetReturnTrue()
        ))
            ->process($this->requestMock, $this->handlerMock);
    }
}
