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
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class WebPageTypeTest extends TestCase
{
    /** @var MockObject|TypoScriptFrontendController */
    private $controllerMock;

    /** @var MockObject|ServerRequestInterface */
    private $requestMock;

    /** @var MockObject|RequestHandlerInterface */
    private $handlerMock;

    public function setUp(): void
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
    public function automaticWebPageGenerationIsDeactivates()
    {
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

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function withAssignedWebPageModelRequestIsDirectlyPassedOverToNextMiddleware(): void
    {
        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['hasWebPage'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->once())
            ->method('hasWebPage')
            ->willReturn(true);

        (new WebPageType($this->controllerMock, $schemaManagerMock, $this->getExtensionConfigurationMockWithGetReturnTrue()))
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
        return [
            'Type is empty, so WebPage is used' => [
                [
                    'tx_schema_webpagetype' => '',
                    'title' => 'A test title',
                    'description' => 'A test description',
                    'endtime' => 0,
                ],
                (new WebPage())
                    ->setProperty('name', 'A test title')
                    ->setProperty('description', 'A test description')
            ],
            'Type is set, so this type is used' => [
                [
                    'tx_schema_webpagetype' => 'ItemPage',
                    'title' => 'An item title',
                    'description' => 'An item description',
                    'endtime' => 0,
                ],
                (new ItemPage())
                    ->setProperty('name', 'An item title')
                    ->setProperty('description', 'An item description')
            ],
            'Endtime is defined, expires is set' => [
                [
                    'tx_schema_webpagetype' => 'WebPage',
                    'title' => 'An item title',
                    'description' => 'An item description',
                    'endtime' => 1561672753,
                ],
                (new WebPage())
                    ->setProperty('name', 'An item title')
                    ->setProperty('description', 'An item description')
                    ->setProperty('expires', '2019-06-27T21:59:13+00:00')
            ],
        ];
    }

    /**
     * @test
     * @dataProvider pagePropertiesProvider
     *
     * @param array $pageProperties
     * @param AbstractType $webPage
     *
     * @covers       \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function withNotAlreadyAssignedWebPageModelPropertiesFromTsfeAreSet(
        array $pageProperties,
        AbstractType $webPage
    ): void {
        $this->controllerMock->page = $pageProperties;

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['hasWebPage', 'setWebPage'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->once())
            ->method('hasWebPage')
            ->willReturn(false);

        $schemaManagerMock
            ->expects($this->once())
            ->method('setWebPage')
            ->with($webPage);

        (new WebPageType($this->controllerMock, $schemaManagerMock, $this->getExtensionConfigurationMockWithGetReturnTrue()))
            ->process($this->requestMock, $this->handlerMock);
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Middleware\WebPageType::process
     */
    public function whenTypeDoesNotExistNoWebPageIsSet(): void
    {
        $this->controllerMock->page = [
            'tx_schema_webpagetype' => 'TypeDoesNotExist',
        ];

        /** @var MockObject|SchemaManager $schemaManagerMock */
        $schemaManagerMock = $this->getMockBuilder(SchemaManager::class)
            ->setMethods(['hasWebPage', 'setWebPage'])
            ->getMock();

        $schemaManagerMock
            ->expects($this->once())
            ->method('hasWebPage')
            ->willReturn(false);

        $schemaManagerMock
            ->expects($this->never())
            ->method('setWebPage');

        (new WebPageType($this->controllerMock, $schemaManagerMock, $this->getExtensionConfigurationMockWithGetReturnTrue()))
            ->process($this->requestMock, $this->handlerMock);
    }
}
