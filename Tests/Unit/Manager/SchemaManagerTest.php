<?php
declare (strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Manager;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\Thing;
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
}
