<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Hooks\PageRenderer;

use Brotkrueml\Schema\Adapter\ApplicationType;
use Brotkrueml\Schema\Adapter\ExtensionAvailability;
use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class SchemaMarkupInjectionTest extends TestCase
{
    protected SchemaMarkupInjection $subject;

    /**
     * @var MockObject|PageRenderer
     */
    protected $pageRendererMock;

    /**
     * @var MockObject|ExtensionConfiguration
     */
    protected $extensionConfigurationMock;

    private SchemaManager $schemaManager;

    /**
     * @var MockObject|TypoScriptFrontendController
     */
    protected $controllerMock;

    /**
     * @var PagesCacheService|MockObject
     */
    private $pagesCacheServiceMock;

    /**
     * @var Stub|ApplicationType
     */
    private $applicationTypeStub;

    /**
     * @var Stub|ExtensionAvailability
     */
    private $extensionAvailabilityStub;

    /**
     * @var Stub|EventDispatcher
     */
    private $eventDispatcherStub;

    protected function setUp(): void
    {
        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $this->controllerMock->newHash = 'somehash';
        $this->controllerMock->page = ['no_index' => 0, 'uid' => 42];

        $this->extensionConfigurationMock = $this->createMock(ExtensionConfiguration::class);
        $this->schemaManager = new SchemaManager();
        $this->pagesCacheServiceMock = $this->createMock(PagesCacheService::class);
        $this->applicationTypeStub = $this->createStub(ApplicationType::class);
        $this->extensionAvailabilityStub = $this->createStub(ExtensionAvailability::class);
        $this->eventDispatcherStub = $this->createStub(EventDispatcher::class);

        $this->eventDispatcherStub
            ->method('dispatch')
            ->willReturn(new RenderAdditionalTypesEvent(false));

        $this->subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $this->pageRendererMock = $this->createMock(PageRenderer::class);
    }

    /**
     * @test
     */
    public function executeInBackendModeDoesNothing(): void
    {
        $this->schemaManager->addType(new GenericStub());

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(true);

        $params = [];
        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithoutDefinedMarkupAndNoAspectsDoesNotEmbedAnything(): void
    {
        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $params = [];
        $this->subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithMarkupDefinedCallsAddHeaderDataIfShouldEmbeddedIntoHead(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupInBodySection' => '0']);

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addFooterData');

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function executeWithSchemaCallsAddFooterDataOnceIfShouldEmbeddedIntoBody(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupInBodySection' => '1']);

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addFooterData')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function seoExtensionIsNotInstalledAddsHeaderData(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $controllerMock->page = ['uid' => 42];

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupInBodySection' => '0']);

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenCacheIsDefinedItIsUsedToGetMarkup(): void
    {
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn('some-cached-markup');

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('some-cached-markup');

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenCacheIsDefinedItIsUsedToStoreMarkup(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenPageShouldBeIndexedThenMarkupIsEmbedded(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenPageShouldNotBeIndexedAndConfigurationOptionIsNotDefinedThenMarkupIsEmbedded(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = ['no_index' => 1, 'uid' => 42];

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn([]);

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenPageShouldNotBeIndexedAndConfigurationOptionIsActivatedThenMarkupIsEmbedded(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = ['no_index' => 1, 'uid' => 42];

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupOnNoindexPages' => '1']);

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenPageShouldNotBeIndexedAndConfigurationOptionIsDeactivatedThenMarkupIsNotEmbedded(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = ['no_index' => 1, 'uid' => 42];

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupOnNoindexPages' => '0']);

        $this->pagesCacheServiceMock
            ->expects(self::never())
            ->method('getMarkupFromCache');

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function whenSeoExtensionIsNotLoadedMarkupIsAlwaysEmbedded(): void
    {
        $this->schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = ['no_index' => 1, 'uid' => 42];

        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupOnNoindexPages' => '0']);

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $this->eventDispatcherStub
        );

        $packageManagerStub = $this->createStub(PackageManager::class);
        $packageManagerStub
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn(false);
        ExtensionManagementUtility::setPackageManager($packageManagerStub);

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    /**
     * @test
     */
    public function additionalTypeAddedViaEventDispatcherIsAddedCorrectly(): void
    {
        $this->extensionConfigurationMock
            ->expects(self::once())
            ->method('get')
            ->with('schema')
            ->willReturn(['embedMarkupOnNoindexPages' => '0']);

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"from-event"}'
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $event = new RenderAdditionalTypesEvent(false);
        $event->addType(new GenericStub('from-event'));
        $eventDispatcherStub = $this->createStub(EventDispatcher::class);
        $eventDispatcherStub
            ->method('dispatch')
            ->willReturn($event);

        $subject = new SchemaMarkupInjection(
            $this->controllerMock,
            $this->extensionConfigurationMock,
            $this->schemaManager,
            $this->pagesCacheServiceMock,
            $this->applicationTypeStub,
            $this->extensionAvailabilityStub,
            $eventDispatcherStub
        );

        $packageManagerStub = $this->createStub(PackageManager::class);
        $packageManagerStub
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn(false);
        ExtensionManagementUtility::setPackageManager($packageManagerStub);

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }
}
