<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Manager;

use Brotkrueml\Schema\Adapter\ApplicationType;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\ItemPage;
use Brotkrueml\Schema\Model\Type\Person;
use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\NoopEventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SchemaManagerTest extends Testcase
{
    use SchemaCacheTrait;

    private SchemaManager $subject;
    private \ReflectionProperty $rendererTypes;
    private Renderer $renderer;
    /**
     * @var ApplicationType&Stub
     */
    private Stub $applicationTypeStub;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $reflector = new \ReflectionClass(Renderer::class);
        $this->rendererTypes = $reflector->getProperty('types');
        $this->rendererTypes->setAccessible(true);

        $this->applicationTypeStub = $this->createStub(ApplicationType::class);
        $this->applicationTypeStub
            ->method('isBackend')
            ->willReturn(false);

        $this->renderer = new Renderer();
        $this->subject = new SchemaManager(
            $this->applicationTypeStub,
            new NoopEventDispatcher(),
            $this->createStub(ExtensionConfiguration::class),
            $this->renderer,
        );
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    #[Test]
    public function hasWebPageReturnsFalseWhenNoWebPageIsSet(): void
    {
        self::assertFalse($this->subject->hasWebPage());
    }

    #[Test]
    public function hasWebPageReturnsTrueWhenWebPageIsSet(): void
    {
        $this->subject->addType(new WebPage());

        self::assertTrue($this->subject->hasWebPage());
    }

    #[Test]
    public function renderJsonLdWithOnBreadcrumbListAndNoWebPageAvailable(): void
    {
        $breadcrumbList = new BreadcrumbList();

        $this->subject->addType($breadcrumbList);
        $this->subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertSame([$breadcrumbList], $actual);
    }

    #[Test]
    public function renderJsonLdWithTwoBreadcrumbListAndNoWebPageAvailable(): void
    {
        $breadcrumbList1 = new BreadcrumbList();
        $breadcrumbList2 = new BreadcrumbList();

        $this->subject->addType($breadcrumbList1);
        $this->subject->addType($breadcrumbList2);
        $this->subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertSame([$breadcrumbList1, $breadcrumbList2], $actual);
    }

    #[Test]
    public function renderJsonLdWithABreadcrumbListInAWebPage(): void
    {
        $webPage = new WebPage();
        $breadcrumbList = new BreadcrumbList();

        $this->subject->addType($breadcrumbList);
        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        self::assertSame([$webPage], $this->rendererTypes->getValue($this->renderer));
        self::assertSame($breadcrumbList, $webPage->getProperty('breadcrumb'));
    }

    #[Test]
    public function renderJsonLdWithABreadcrumbListInAWebPageAndAnAdditionalWebPage(): void
    {
        $breadcrumbList1 = new BreadcrumbList();
        $breadcrumbList2 = new BreadcrumbList();

        $webPage = new WebPage();
        $webPage->setProperty('breadcrumb', $breadcrumbList2);

        $this->subject->addType($breadcrumbList1);
        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('breadcrumb');

        self::assertSame([$breadcrumbList1, $breadcrumbList2], $actual);
    }

    #[Test]
    public function renderJsonLdWithTwoBreadcrumbListInAWebPage(): void
    {
        $breadcrumbLists = [new BreadcrumbList(), new BreadcrumbList()];

        $webPage = new WebPage();
        $webPage->setProperty('breadcrumb', $breadcrumbLists);

        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('breadcrumb');

        self::assertSame($breadcrumbLists, $actual);
    }

    #[Test]
    public function renderJsonLdWithAWrongTypeAsBreadcrumbListInWebPageIsIgnored(): void
    {
        $breadcrumbList = new BreadcrumbList();

        $webPage = new WebPage();
        $webPage->setProperty('breadcrumb', $breadcrumbList);
        $webPage->addProperty('breadcrumb', new Thing());

        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('breadcrumb');

        self::assertSame($breadcrumbList, $actual);
    }

    #[Test]
    public function renderJsonLdWithWebPageAndOneMainEntityDefined(): void
    {
        $thing = new Thing();

        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', $thing);

        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('mainEntity');

        self::assertSame($thing, $actual);
    }

    #[Test]
    public function renderJsonLdWithWebPageAndOneInvalidMainEntityDefined(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', 'some string');

        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('mainEntity');

        self::assertNull($actual);
    }

    #[Test]
    public function renderJsonLdWithWebPageAndTwoMainEntitiesDefined(): void
    {
        $thing1 = new Thing();
        $thing2 = new Thing();

        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', $thing1);
        $webPage->addProperty('mainEntity', $thing2);

        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('mainEntity');

        self::assertSame([$thing1, $thing2], $actual);
    }

    #[Test]
    public function renderJsonLdWithWebPageAndTwoMainEntitiesDefinedOneIsInvalid(): void
    {
        $thing = new Thing();

        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', $thing);
        $webPage->addProperty('mainEntity', 'some string');

        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        $actual = $webPage->getProperty('mainEntity');

        self::assertSame($thing, $actual);
    }

    #[Test]
    public function addTypeWithWebPageSetTwiceThenTheSecondOneOverridesTheFirstOne(): void
    {
        $webPage = new WebPage();
        $itemPage = new ItemPage();

        $this->subject->addType($webPage);
        $this->subject->addType($itemPage);
        $this->subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertSame([$itemPage], $actual);
    }

    #[Test]
    public function renderJsonLdWithSomeTypesAreHandledCorrectly(): void
    {
        $thing = new Thing();
        $person = new Person();

        $this->subject->addType($thing);
        $this->subject->addType($person);
        $this->subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertSame([$thing, $person], $actual);
    }

    #[Test]
    public function addMainEntityOfWebPageCalledMultipleTimesWithNotPrioritisedTypes(): void
    {
        $thing = new Thing();
        $person = new Person();
        $webPage = new WebPage();

        $this->subject->addMainEntityOfWebPage($thing);
        $this->subject->addMainEntityOfWebPage($person);
        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        self::assertSame([$webPage], $this->rendererTypes->getValue($this->renderer));
        self::assertSame([$thing, $person], $webPage->getProperty('mainEntity'));
    }

    #[Test]
    public function addMainEntityOfWebPageCalledMultipleTimesWithMixedPrioritisedAndNotPrioritisedTypes(): void
    {
        $person1 = new Person();
        $person2 = new Person();
        $person3 = new Person();
        $person4 = new Person();
        $webPage = new WebPage();

        $this->subject->addMainEntityOfWebPage($person1, false);
        $this->subject->addMainEntityOfWebPage($person2, true);
        $this->subject->addMainEntityOfWebPage($person3, false);
        $this->subject->addMainEntityOfWebPage($person4, true);
        $this->subject->addType($webPage);
        $this->subject->renderJsonLd();

        self::assertContains($webPage, $this->rendererTypes->getValue($this->renderer));
        self::assertContains($person1, $this->rendererTypes->getValue($this->renderer));
        self::assertContains($person3, $this->rendererTypes->getValue($this->renderer));
        self::assertContains($person2, $webPage->getProperty('mainEntity'));
        self::assertContains($person4, $webPage->getProperty('mainEntity'));
    }

    #[Test]
    public function typesFromInitialiseTypesEventIsAdded(): void
    {
        $type1 = new ProductStub();
        $type2 = new ServiceStub();

        $eventDispatcherStub = new class($type1, $type2) implements EventDispatcherInterface {
            /**
             * @var TypeInterface[]
             */
            private readonly array $types;

            public function __construct(TypeInterface ...$types)
            {
                $this->types = $types;
            }

            public function dispatch(object $event)
            {
                \array_map([$event, 'addType'], $this->types);

                return $event;
            }
        };

        $subject = new SchemaManager(
            $this->applicationTypeStub,
            $eventDispatcherStub,
            $this->createStub(ExtensionConfiguration::class),
            $this->renderer,
        );

        $subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertCount(2, $actual);
        self::assertContains($type1, $actual);
        self::assertContains($type2, $actual);
    }

    #[Test]
    public function onlyOneBreadCrumbListIsRenderedIfExtensionConfigurationIsEnabled(): void
    {
        $extensionConfigurationStub = $this->createStub(ExtensionConfiguration::class);
        $extensionConfigurationStub
            ->method('get')
            ->with('schema', 'allowOnlyOneBreadcrumbList')
            ->willReturn('1');

        $subject = new SchemaManager(
            $this->applicationTypeStub,
            new NoopEventDispatcher(),
            $extensionConfigurationStub,
            $this->renderer,
        );

        $breadcrumbList1 = new BreadcrumbList();
        $breadcrumbList2 = new BreadcrumbList();

        $subject->addType($breadcrumbList1);
        $subject->addType($breadcrumbList2);

        $subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertCount(1, $actual);
        self::assertSame($breadcrumbList2, $actual[0]);
    }

    #[Test]
    public function allBreadCrumbListsAreRenderedIfExtensionConfigurationIsDisabled(): void
    {
        $extensionConfigurationStub = $this->createStub(ExtensionConfiguration::class);
        $extensionConfigurationStub
            ->method('get')
            ->with('schema', 'allowOnlyOneBreadcrumbList')
            ->willReturn('0');

        $subject = new SchemaManager(
            $this->applicationTypeStub,
            new NoopEventDispatcher(),
            $extensionConfigurationStub,
            $this->renderer,
        );

        $breadcrumbList1 = new BreadcrumbList();
        $breadcrumbList2 = new BreadcrumbList();

        $subject->addType($breadcrumbList1);
        $subject->addType($breadcrumbList2);

        $subject->renderJsonLd();

        $actual = $this->rendererTypes->getValue($this->renderer);

        self::assertCount(2, $actual);
        self::assertContains($breadcrumbList1, $actual);
        self::assertContains($breadcrumbList2, $actual);
    }

    #[Test]
    public function addTypeReturnsInstanceOfSelf(): void
    {
        self::assertSame($this->subject, $this->subject->addType(new Thing()));
    }

    #[Test]
    public function addMainEntityOfWebPageReturnsInstanceOfSelf(): void
    {
        self::assertSame($this->subject, $this->subject->addMainEntityOfWebPage(new Thing()));
    }

    #[Test]
    public function multipleCallsOfRenderJsonLd(): void
    {
        $this->subject->addType(new Thing());

        $this->subject->renderJsonLd();
        self::assertCount(1, $this->rendererTypes->getValue($this->renderer));

        $this->subject->renderJsonLd();
        self::assertCount(1, $this->rendererTypes->getValue($this->renderer));
    }

    #[Test]
    public function inBackendContextTheEventDispatcherIsNotCalled(): void
    {
        self::expectNotToPerformAssertions();

        $applicationTypeStub = $this->createStub(ApplicationType::class);
        $applicationTypeStub
            ->method('isBackend')
            ->willReturn(true);

        $eventDispatcherStub = new class() implements EventDispatcherInterface {
            public function dispatch(object $event)
            {
                throw new \Exception('dispatch() method must not be called');
            }
        };

        new SchemaManager(
            $applicationTypeStub,
            $eventDispatcherStub,
            $this->createStub(ExtensionConfiguration::class),
            $this->renderer,
        );
    }
}
