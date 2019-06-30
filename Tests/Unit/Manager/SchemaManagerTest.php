<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Manager;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\CollectionPage;
use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Model\Type\WebPage;
use PHPUnit\Framework\TestCase;

class SchemaManagerTest extends Testcase
{
    /**
     * @var SchemaManager
     */
    protected $schemaManager;

    public function setUp(): void
    {
        $this->schemaManager = new SchemaManager();
    }

    /**
     * @test
     */
    public function renderJsonLdWithNoTypeAddedReturnsEmptyString(): void
    {
        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('', $actual);
    }

    /**
     * @test
     */
    public function renderJsonLdWithOneTypeAddedReturnsCorrectJson(): void
    {
        $actual = $this->schemaManager
            ->addType((new Thing())->setProperty('name', 'Some test thing'))
            ->renderJsonLd();

        $expected = '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","name":"Some test thing"}</script>';

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function renderJsonLdWithTwoTypesAddedReturnsCorrectJsonArray(): void
    {
        $actual = $this->schemaManager
            ->addType((new Thing())->setProperty('name', 'Some test thing'))
            ->addType((new Thing())->setId('someId')->setProperty('name', 'Some other thing'))
            ->renderJsonLd();

        $expected = '<script type="application/ld+json">[{"@context":"http://schema.org","@type":"Thing","name":"Some test thing"},{"@context":"http://schema.org","@type":"Thing","@id":"someId","name":"Some other thing"}]</script>';

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function renderJsonLdWithOneEmptyTypeAddedReturnsEmptyString(): void
    {
        $actual = $this->schemaManager
            ->addType((new Thing()))
            ->renderJsonLd();

        $this->assertSame('', $actual);
    }

    /**
     * @test
     */
    public function addedWebPageIsAvailableAndRendersCorrectly(): void
    {
        $webPage = (new WebPage())->setProperty('name', 'Some web page');
        $this->schemaManager->addType($webPage);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","name":"Some web page"}</script>', $actual);
    }

    /**
     * @test
     */
    public function onlyOneWebPageIsUsedWhenAddingMoreThanOne(): void
    {
        $webPage = (new WebPage())->setProperty('name', 'Some web page');
        $this->schemaManager->addType($webPage);

        $collectionPage = (new CollectionPage())->setProperty('name', 'Some collection page');
        $this->schemaManager->addType($collectionPage);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"CollectionPage","name":"Some collection page"}</script>', $actual);
    }

    /**
     * @test
     */
    public function addBreadcrumbListRendersCorrectly(): void
    {
        $breadcrumbList1 = (new BreadcrumbList())->setProperty('name', 'some breadcrumb list');
        $this->schemaManager->addType($breadcrumbList1);

        $actual1 = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","name":"some breadcrumb list"}</script>', $actual1);

        $breadcrumbList2 = (new BreadcrumbList())->setProperty('name', 'another breadcrumb list');
        $this->schemaManager->addType($breadcrumbList2);

        $actual2 = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">[{"@context":"http://schema.org","@type":"BreadcrumbList","name":"some breadcrumb list"},{"@context":"http://schema.org","@type":"BreadcrumbList","name":"another breadcrumb list"}]</script>', $actual2);
    }

    /**
     * @test
     */
    public function addBreadcrumbListIndependentFromWebPageIncludesBreadcrumbIntoWebPageMarkup(): void
    {
        $webPage = (new WebPage())->setProperty('name', 'Some web page');
        $this->schemaManager->addType($webPage);

        $breadcrumbList1 = (new BreadcrumbList())->setProperty('name', 'some breadcrumb list');
        $this->schemaManager->addType($breadcrumbList1);

        $breadcrumbList2 = (new BreadcrumbList())->setProperty('name', 'another breadcrumb list');
        $this->schemaManager->addType($breadcrumbList2);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"some breadcrumb list"},{"@type":"BreadcrumbList","name":"another breadcrumb list"}],"name":"Some web page"}</script>', $actual);
    }

    /**
     * @test
     */
    public function breadcrumbFromWebPageIsMergedWithIndependentlySetBreadcrumb(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'Breadcrumb in WebPage')
        );
        $this->schemaManager->addType($webPage);

        $breadcrumbList = (new BreadcrumbList())->setProperty('name', 'Independent breadcrumb');
        $this->schemaManager->addType($breadcrumbList);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"Breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Independent breadcrumb"}]}</script>', $actual);
    }

    /**
     * @test
     */
    public function multipleBreadcrumbsFromWebPageAreMergedWithIndependentlySetBreadcrumb(): void
    {
        $webPage = new WebPage();
        $webPage->addProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'One breadcrumb in WebPage')
        );
        $webPage->addProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'Another breadcrumb in WebPage')
        );
        $this->schemaManager->addType($webPage);

        $breadcrumbList = (new BreadcrumbList())->setProperty('name', 'Independent breadcrumb');
        $this->schemaManager->addType($breadcrumbList);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"One breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Another breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Independent breadcrumb"}]}</script>', $actual);
    }

    /**
     * @test
     */
    public function breadcrumbsFromWebPageWhichAreNotOfTypeBreadcrumbListAreIgnored(): void
    {
        $webPage = new WebPage();
        $webPage->addProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'BreadcrumbList breadcrumb in WebPage')
        );
        $webPage->addProperty(
            'breadcrumb',
            (new Thing())->setProperty('name', 'Thingy breadcrumb in WebPage')
        );
        $this->schemaManager->addType($webPage);

        $breadcrumbList = (new BreadcrumbList())->setProperty('name', 'Independent breadcrumb');
        $this->schemaManager->addType($breadcrumbList);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"BreadcrumbList breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Independent breadcrumb"}]}</script>', $actual);
    }
}
