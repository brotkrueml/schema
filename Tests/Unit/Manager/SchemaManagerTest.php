<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Manager;

use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\ItemPage;
use Brotkrueml\Schema\Model\Type\Person;
use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SchemaManagerTest extends Testcase
{
    use SchemaCacheTrait;

    /** @var SchemaManager */
    protected $subject;

    /** @var \ReflectionProperty */
    private $rendererTypes;

    /** @var Renderer */
    private $renderer;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $reflector = new \ReflectionClass(Renderer::class);
        $this->rendererTypes = $reflector->getProperty('types');
        $this->rendererTypes->setAccessible(true);

        $this->renderer = new Renderer();

        $this->subject = new SchemaManager($this->renderer);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function hasWebPageReturnsFalseWhenNoWebPageIsSet(): void
    {
        self::assertFalse($this->subject->hasWebPage());
    }

    /**
     * @test
     */
    public function hasWebPageReturnsTrueWhenWebPageIsSet(): void
    {
        $this->subject->addType(new WebPage());

        self::assertTrue($this->subject->hasWebPage());
    }

    /**
     * @test
     */
    public function renderJsonLdWithOnBreadcrumbListAndNoWebPageAvailable(): void
    {
        $breadcrumbList = new BreadcrumbList();

        $subject = new SchemaManager($this->renderer);
        $subject->addType($breadcrumbList);
        $subject->renderJsonLd();

        self::assertSame([$breadcrumbList], $this->rendererTypes->getValue($this->renderer));
    }

    /**
     * @test
     */
    public function renderJsonLdWithTwoBreadcrumbListAndNoWebPageAvailable(): void
    {
        $breadcrumbList1 = new BreadcrumbList();
        $breadcrumbList2 = new BreadcrumbList();

        $subject = new SchemaManager($this->renderer);
        $subject->addType($breadcrumbList1);
        $subject->addType($breadcrumbList2);
        $subject->renderJsonLd();

        self::assertSame([$breadcrumbList1, $breadcrumbList2], $this->rendererTypes->getValue($this->renderer));
    }

    /**
     * @test
     */
    public function renderJsonLdWithABreadcrumbListInAWebPage(): void
    {
        $webPage = new WebPage();
        $breadcrumbList = new BreadcrumbList();

        $subject = new SchemaManager($this->renderer);
        $subject->addType($breadcrumbList);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame([$webPage], $this->rendererTypes->getValue($this->renderer));
        self::assertSame($breadcrumbList, $webPage->getProperty('breadcrumb'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithABreadcrumbListInAWebPageAndAnAdditionalWebPage(): void
    {
        $breadcrumbList1 = new BreadcrumbList();
        $breadcrumbList2 = new BreadcrumbList();

        $webPage = new WebPage();
        $webPage->setProperty('breadcrumb', $breadcrumbList2);

        $subject = new SchemaManager($this->renderer);
        $subject->addType($breadcrumbList1);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        $this->rendererTypes->getValue($this->renderer);

        self::assertSame([$breadcrumbList1, $breadcrumbList2], $webPage->getProperty('breadcrumb'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithTwoBreadcrumbListInAWebPage(): void
    {
        $breadcrumbLists = [new BreadcrumbList(), new BreadcrumbList()];

        $webPage = new WebPage();
        $webPage->setProperty('breadcrumb', $breadcrumbLists);

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame($breadcrumbLists, $webPage->getProperty('breadcrumb'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithAWrongTypeAsBreadcrumbListInWebPageIsIgnored(): void
    {
        $breadcrumbList = new BreadcrumbList();

        $webPage = new WebPage();
        $webPage->setProperty('breadcrumb', $breadcrumbList);
        $webPage->addProperty('breadcrumb', new Thing());

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame($breadcrumbList, $webPage->getProperty('breadcrumb'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithWebPageAndOneMainEntityDefined(): void
    {
        $thing = new Thing();

        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', $thing);

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame($thing, $webPage->getProperty('mainEntity'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithWebPageAndOneInvalidMainEntityDefined(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', 'some string');

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertNull($webPage->getProperty('mainEntity'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithWebPageAndTwoMainEntitiesDefined(): void
    {
        $thing1 = new Thing();
        $thing2 = new Thing();

        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', $thing1);
        $webPage->addProperty('mainEntity', $thing2);

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame([$thing1, $thing2], $webPage->getProperty('mainEntity'));
    }

    /**
     * @test
     */
    public function renderJsonLdWithWebPageAndTwoMainEntitiedDefinedOneIsInvalid(): void
    {
        $thing = new Thing();

        $webPage = new WebPage();
        $webPage->setProperty('mainEntity', $thing);
        $webPage->addProperty('mainEntity', 'some string');

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame($thing, $webPage->getProperty('mainEntity'));
    }

    /**
     * @test
     */
    public function addTypeWithWebPageSetTwiceThanTheSecondOneOverridesTheFirstOne(): void
    {
        $webPage = new WebPage();
        $itemPage = new ItemPage();

        $subject = new SchemaManager($this->renderer);
        $subject->addType($webPage);
        $subject->addType($itemPage);

        $subject->renderJsonLd();

        self::assertSame([$itemPage], $this->rendererTypes->getValue($this->renderer));
    }

    /**
     * @test
     */
    public function renderJsonLdWithSomeTypesAreHandledCorrectly(): void
    {
        $thing = new Thing();
        $person = new Person();

        $subject = new SchemaManager($this->renderer);
        $subject->addType($thing);
        $subject->addType($person);
        $subject->renderJsonLd();

        self::assertSame([$thing, $person], $this->rendererTypes->getValue($this->renderer));
    }

    /**
     * @test
     */
    public function addMainEntityOfWebPageCalledMultipleTimes(): void
    {
        $thing = new Thing();
        $person = new Person();
        $webPage = new WebPage();

        $subject = new SchemaManager($this->renderer);
        $subject->addMainEntityOfWebPage($thing);
        $subject->addMainEntityOfWebPage($person);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame([$webPage], $this->rendererTypes->getValue($this->renderer));
        self::assertSame([$thing, $person], $webPage->getProperty('mainEntity'));
    }

    /**
     * @test
     */
    public function setMainEntityOfWebPageCalledMultipleTime(): void
    {
        $this->expectDeprecation();

        $thing = new Thing();
        $person = new Person();
        $webPage = new WebPage();

        $subject = new SchemaManager($this->renderer);
        $subject->setMainEntityOfWebPage($thing);
        $subject->setMainEntityOfWebPage($person);
        $subject->addType($webPage);
        $subject->renderJsonLd();

        self::assertSame([$webPage], $this->rendererTypes->getValue($this->renderer));
        self::assertSame([$thing, $person], $webPage->getProperty('mainEntity'));
    }

    /**
     * @test
     */
    public function addTypeReturnsInstanceOfSelf(): void
    {
        $subject = new SchemaManager($this->renderer);

        self::assertSame($subject, $subject->addType(new Thing()));
    }

    /**
     * @test
     */
    public function setMainEntityOfWebPageReturnsInstanceOfSelf(): void
    {
        $this->expectDeprecation();

        $subject = new SchemaManager($this->renderer);

        self::assertSame($subject, $subject->setMainEntityOfWebPage(new Thing()));
    }

    /**
     * @test
     */
    public function addMainEntityOfWebPageReturnsInstanceOfSelf(): void
    {
        $subject = new SchemaManager($this->renderer);

        self::assertSame($subject, $subject->addMainEntityOfWebPage(new Thing()));
    }

    /**
     * @test
     */
    public function multipleCallsOfRenderJsonLd(): void
    {
        $subject = new SchemaManager($this->renderer);
        $subject->addType(new Thing());

        $subject->renderJsonLd();
        self::assertCount(1, $this->rendererTypes->getValue($this->renderer));

        $subject->renderJsonLd();
        self::assertCount(1, $this->rendererTypes->getValue($this->renderer));
    }
}
