<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Type;

use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Type\ModelClassNotFoundException;
use Brotkrueml\Schema\Type\TypeProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brotkrueml\Schema\Type\TypeProvider
 */
final class TypeProviderTest extends TestCase
{
    private TypeProvider $subject;

    protected function setUp(): void
    {
        $this->subject = new TypeProvider();
    }

    /**
     * @test
     */
    public function getTypesReturnsTypesCorrectlyWhenTypesAreAdded(): void
    {
        $this->subject->addType('3DModel', FixtureType\_3DModel::class);
        $this->subject->addType('Table', FixtureType\Table::class);
        $this->subject->addType('Thing', FixtureType\Thing::class);
        $this->subject->addType('VideoGallery', FixtureType\VideoGallery::class);

        $actual = $this->subject->getTypes();

        self::assertCount(4, $actual);
        self::assertTrue(\array_is_list($actual));
        self::assertContains('3DModel', $actual);
        self::assertContains('Table', $actual);
        self::assertContains('Thing', $actual);
        self::assertContains('VideoGallery', $actual);
    }

    /**
     * @test
     */
    public function getTypesReturnsTypesCorrectlyWhenNoTypesAreAdded(): void
    {
        $actual = $this->subject->getTypes();

        self::assertSame([], $actual);
    }

    /**
     * @test
     */
    public function getWebPageTypesWhenTypesAreAdded(): void
    {
        $this->subject->addType('Table', FixtureType\Table::class);
        $this->subject->addType('Thing', FixtureType\Thing::class);
        $this->subject->addType('VideoGallery', FixtureType\VideoGallery::class);
        $this->subject->addType('WebPage', FixtureType\WebPage::class);

        $actual = $this->subject->getWebPageTypes();

        self::assertCount(2, $actual);
        self::assertTrue(\array_is_list($actual));
        self::assertContains('VideoGallery', $actual);
        self::assertContains('WebPage', $actual);
    }

    /**
     * @test
     */
    public function getWebPageTypesReturnsTypesCorrectlyWhenNoTypesAreAdded(): void
    {
        $actual = $this->subject->getWebPageTypes();

        self::assertSame([], $actual);
    }

    /**
     * @test
     */
    public function getModelClassNameForTypeReturnTypeCorrectly(): void
    {
        $this->subject->addType('Thing', FixtureType\Thing::class);

        $actual = $this->subject->getModelClassNameForType('Thing');

        self::assertSame(FixtureType\Thing::class, $actual);
    }

    /**
     * @test
     */
    public function getModelClassNameForTypeThrowsExceptionIfTypeIsNotAvailable(): void
    {
        $this->expectException(ModelClassNotFoundException::class);

        $this->subject->getModelClassNameForType('UnknownType');
    }
}
