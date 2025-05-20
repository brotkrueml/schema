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
use Brotkrueml\Schema\Caching\PersistentCacheHandler;
use Brotkrueml\Schema\Caching\RuntimeCacheHandler;
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
use TYPO3\CMS\Frontend\Page\PageInformation;

#[CoversClass(SchemaMarkupInjection::class)]
#[RunTestsInSeparateProcesses]
final class SchemaMarkupInjectionTest extends TestCase
{
    private MockObject $pageRendererMock;
    private MockObject $persistentCacheHandlerMock;
    private MockObject $runtimeCacheHandlerMock;
    private ApplicationType&Stub $applicationTypeStub;
    private ExtensionAvailability&Stub $extensionAvailabilityStub;
    private ServerRequestInterface&Stub $requestStub;

    protected function setUp(): void
    {
        $this->applicationTypeStub = self::createStub(ApplicationType::class);
        $this->extensionAvailabilityStub = self::createStub(ExtensionAvailability::class);
        $this->persistentCacheHandlerMock = $this->createMock(PersistentCacheHandler::class);
        $this->runtimeCacheHandlerMock = $this->createMock(RuntimeCacheHandler::class);

        $this->pageRendererMock = $this->createMock(PageRenderer::class);

        $this->requestStub = self::createStub(ServerRequestInterface::class);
        $GLOBALS['TYPO3_REQUEST'] = $this->requestStub;
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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
            $schemaManager,
        );
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function executeWithoutDefinedMarkupAndNoBreadcrumbAndWebpageDoesNotEmbedAnything(): void
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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
            $schemaManager,
        );

        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function executeWithMarkupDefinedCallsAddHeaderDataIfShouldEmbeddedIntoHead(): void
    {
        $configuration = $this->buildConfiguration(embedMarkupInBodySection: false);

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType((new GenericStub())->setId('some-type'));

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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new GenericStub())->setId('some-type'));

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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new GenericStub())->setId('some-type'));

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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
    public function markupIsRetrievedFromCache(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());

        $this->persistentCacheHandlerMock
            ->expects(self::once())
            ->method('getMarkup')
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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function runtimeCacheIsUsedToStoreMarkupIfMarkupWasRetrievedFromCache(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());

        $this->persistentCacheHandlerMock
            ->expects(self::once())
            ->method('getMarkup')
            ->with($this->requestStub)
            ->willReturn('some-cached-markup');
        $this->runtimeCacheHandlerMock
            ->expects(self::once())
            ->method('setMarkup')
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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
            $schemaManager,
        );

        $params = [];
        $subject->execute($params, $this->pageRendererMock);
    }

    #[Test]
    public function runtimeCacheIsUsedToStoreMarkupIfMarkupWasNotRetrievedFromCache(): void
    {
        $configuration = $this->buildConfiguration();

        $schemaManager = new SchemaManager($configuration, new Renderer());
        $schemaManager->addType((new GenericStub())->setId('some-type'));

        $this->persistentCacheHandlerMock
            ->expects(self::once())
            ->method('getMarkup')
            ->with($this->requestStub)
            ->willReturn(null);
        $this->runtimeCacheHandlerMock
            ->expects(self::once())
            ->method('setMarkup')
            ->with('<script type="application/ld+json" id="ext-schema-jsonld">{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}</script>');

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
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new GenericStub())->setId('some-type'));

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => 0,
        ]);
        $this->requestStub
            ->method('getAttribute')
            ->with('frontend.page.information')
            ->willReturn($pageInformation);

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json" id="ext-schema-jsonld">{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}</script>');

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new GenericStub())->setId('some-type'));

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => 1,
        ]);
        $this->requestStub
            ->method('getAttribute')
            ->with('frontend.page.information')
            ->willReturn($pageInformation);

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json" id="ext-schema-jsonld">{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}</script>');

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new GenericStub())->setId('some-type'));

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => 1,
        ]);
        $this->requestStub
            ->method('getAttribute')
            ->with('frontend.page.information')
            ->willReturn($pageInformation);

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(true);

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addHeaderData');

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new GenericStub())->setId('some-type'));

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => 1,
        ]);
        $this->requestStub
            ->method('getAttribute')
            ->with('frontend.page.information')
            ->willReturn($pageInformation);

        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn(false);

        $this->pageRendererMock
            ->expects(self::once())
            ->method('addHeaderData')
            ->with('<script type="application/ld+json" id="ext-schema-jsonld">{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-type"}</script>');

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            new NoopEventDispatcher(),
            $this->extensionAvailabilityStub,
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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

        $this->runtimeCacheHandlerMock
            ->expects(self::once())
            ->method('setMarkup')
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
        $event->addType((new GenericStub())->setId('from-event'));
        $eventDispatcherStub = self::createStub(EventDispatcher::class);
        $eventDispatcherStub
            ->method('dispatch')
            ->willReturn($event);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            $eventDispatcherStub,
            $this->extensionAvailabilityStub,
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
        $schemaManager->addType((new WebPageStub())->defineProperties([
            'breadcrumb' => null,
            'mainEntity' => null,
        ]));

        $this->runtimeCacheHandlerMock
            ->expects(self::once())
            ->method('setMarkup')
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
        $event->addMainEntityOfWebPage((new GenericStub())->setId('from-event-as-main-entity'));
        $eventDispatcherStub = self::createStub(EventDispatcher::class);
        $eventDispatcherStub
            ->method('dispatch')
            ->willReturn($event);

        $subject = new SchemaMarkupInjection(
            $this->applicationTypeStub,
            $configuration,
            $eventDispatcherStub,
            $this->extensionAvailabilityStub,
            $this->persistentCacheHandlerMock,
            $this->runtimeCacheHandlerMock,
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
