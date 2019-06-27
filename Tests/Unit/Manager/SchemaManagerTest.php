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
    public function getWebPageReturnsNullIfNotPreviouslySet(): void
    {
        $actual = $this->schemaManager->getWebPage();

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function setWebPageReturnsInstanceOfItself(): void
    {
        $model = new WebPage();

        $actual = $this->schemaManager->setWebPage($model);

        $this->assertInstanceOf(SchemaManager::class, $actual);
    }

    /**
     * @test
     */
    public function getAndSetWebPageWorkingCorrectly(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty('name', 'some web page name');

        $actual = $this->schemaManager
            ->setWebPage($webPage)
            ->getWebPage();

        $this->assertSame($webPage, $actual);
    }

    /**
     * @test
     */
    public function hasWebPageReturnsFalseWhenNoModelIsAssigned(): void
    {
        $actual = $this->schemaManager->hasWebPage();

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function hasWebPageReturnsTrueWhenModelIsAssigned(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty('name', 'some web page name');

        $actual = $this->schemaManager
            ->setWebPage($webPage)
            ->hasWebPage();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function renderJsonLdWithSetWebPageReturnsCorrectOutput(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty('name', 'some web page name');

        $this->schemaManager->setWebPage($webPage);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertEquals(
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","name":"some web page name"}</script>',
            $actual
        );
    }

    /**
     * @test
     */
    public function setWebPageWithWrongModelThrowsException(): void
    {
        $this->expectException(\DomainException::class);

        $thing = new Thing();
        $this->schemaManager->setWebPage($thing);
    }

    /**
     * @test
     */
    public function setAddTypeWithWebPageTypeSetsCorrectWebPageProperty(): void
    {
        $webPage = new WebPage();
        $this->schemaManager->addType($webPage);

        $actual = $this->schemaManager->getWebPage();

        $this->assertSame($webPage, $actual);
    }
}
