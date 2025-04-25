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
use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\WebPageStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\EventDispatcher\NoopEventDispatcher;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

#[CoversClass(SchemaMarkupInjection::class)]
#[RunTestsInSeparateProcesses]
final class SchemaMarkupInjectionTest extends TestCase
{
    private MockObject $pageRendererMock;
    private MockObject $controllerMock;
    private MockObject $pagesCacheServiceMock;
    private ApplicationType&Stub $applicationTypeStub;
    private ExtensionAvailability&Stub $extensionAvailabilityStub;

    protected function setUp(): void
    {
        $this->pagesCacheServiceMock = $this->createMock(PagesCacheService::class);
        $this->applicationTypeStub = self::createStub(ApplicationType::class);
        $this->extensionAvailabilityStub = self::createStub(ExtensionAvailability::class);

        $this->pageRendererMock = $this->createMock(PageRenderer::class);

        $this->controllerMock = $this->createMock(TypoScriptFrontendController::class);
        $this->controllerMock->newHash = 'somehash';
        $this->controllerMock->page = [
            'no_index' => 0,
            'uid' => 42,
        ];

        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->with('frontend.controller')
            ->willReturn($this->controllerMock);

        $GLOBALS['TYPO3_REQUEST'] = $requestStub;
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TYPO3_REQUEST']);
    }

    #[Test]
    public function executeInBackendModeDoesNothing(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub());

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

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function executeWithoutDefinedMarkupAndNoBreacrumbAndWebpageDoesNotEmbedAnything(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());

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

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function executeWithMarkupDefinedCallsAddHeaderDataIfShouldEmbeddedIntoHead(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupInBodySection: false);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
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
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function executeWithSchemaCallsAddFooterDataOnceIfShouldEmbeddedIntoBody(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupInBodySection: true);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addFooterData')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function seoExtensionIsNotInstalledAddsHeaderData(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupInBodySection: false);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = [
            'uid' => 42,
        ];

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
            ));

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function whenCacheIsDefinedItIsUsedToGetMarkup(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());

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
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function whenCacheIsDefinedItIsUsedToStoreMarkup(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function whenPageShouldBeIndexedThenMarkupIsEmbedded(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function whenPageShouldNotBeIndexedAndEmbedMarkupOnNoIndexPagesIsTrueThenMarkupIsEmbedded(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupOnNoIndexPages: true);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = [
            'no_index' => 1,
            'uid' => 42,
        ];

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function whenPageShouldNotBeIndexedAndConfigurationOptionIsDeactivatedThenMarkupIsNotEmbedded(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupOnNoIndexPages: false);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = [
            'no_index' => 1,
            'uid' => 42,
        ];

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
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function whenSeoExtensionIsNotLoadedMarkupIsAlwaysEmbedded(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupOnNoIndexPages: false);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new GenericStub('some-type'));

        $this->controllerMock->page = [
            'no_index' => 1,
            'uid' => 42,
        ];

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $packageManagerStub = self::createStub(PackageManager::class);
        $packageManagerStub
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn(false);
        ExtensionManagementUtility::setPackageManager($packageManagerStub);

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function additionalTypeAddedViaEventDispatcherIsAddedCorrectly(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"GenericStub","@id":"from-event"}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $event = new RenderAdditionalTypesEvent(
            false,
            false,
            self::createStub(ServerRequestInterface::class),
        );
        $event->addType(new GenericStub('from-event'));
        $eventDispatcherStub = self::createStub(EventDispatcher::class);
        $eventDispatcherStub
            ->method('dispatch')
            ->willReturn($event);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            $eventDispatcherStub,
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $packageManagerStub = self::createStub(PackageManager::class);
        $packageManagerStub
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn(false);
        ExtensionManagementUtility::setPackageManager($packageManagerStub);

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function mainEntitiesAddedViaEventDispatcherAreAddedCorrectly(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType(new WebPageStub());

        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('getMarkupFromCache')
            ->willReturn(null);
        $this->pagesCacheServiceMock
            ->expects(self::once())
            ->method('storeMarkupInCache')
            ->with(\sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@type":"WebPageStub","mainEntity":{"@type":"GenericStub","@id":"from-event-as-main-entity"}}',
            ));

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $event = new RenderAdditionalTypesEvent(
            false,
            false,
            self::createStub(ServerRequestInterface::class),
        );
        $event->addMainEntityOfWebPage(new GenericStub('from-event-as-main-entity'));
        $eventDispatcherStub = self::createStub(EventDispatcher::class);
        $eventDispatcherStub
            ->method('dispatch')
            ->willReturn($event);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            $eventDispatcherStub,
            $this->extensionAvailabilityStub,
            $this->pagesCacheServiceMock,
            $schemaManager,
        );

        $packageManagerStub = self::createStub(PackageManager::class);
        $packageManagerStub
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn(false);
        ExtensionManagementUtility::setPackageManager($packageManagerStub);

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    private function buildConfiguration(
        bool $embedMarkupInBodySection = false,
        bool $embedMarkupOnNoIndexPages = false,
    ): Configuration {
        return new Configuration(
            false,
            false,
            [],
            false,
            $embedMarkupInBodySection,
            $embedMarkupOnNoIndexPages,
        );
    }
}
