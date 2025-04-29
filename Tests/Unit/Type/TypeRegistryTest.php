<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Type;

use Brotkrueml\Schema\Manual\Publisher;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Type\ModelClassNotFoundException;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypeRegistry::class)]
final class TypeRegistryTest extends TestCase
{
    private TypeRegistry $subject;

    protected function setUp(): void
    {
        $this->subject = new TypeRegistry();
    }

    #[Test]
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

    #[Test]
    public function getTypesReturnsTypesCorrectlyWhenNoTypesAreAdded(): void
    {
        $actual = $this->subject->getTypes();

        self::assertSame([], $actual);
    }

    #[Test]
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

    #[Test]
    public function getWebPageTypesReturnsTypesCorrectlyWhenNoTypesAreAdded(): void
    {
        $actual = $this->subject->getWebPageTypes();

        self::assertSame([], $actual);
    }

    #[Test]
    public function getModelClassNameForTypeReturnTypeCorrectly(): void
    {
        $this->subject->addType('Thing', FixtureType\Thing::class);

        $actual = $this->subject->getModelClassNameForType('Thing');

        self::assertSame(FixtureType\Thing::class, $actual);
    }

    #[Test]
    public function getModelClassNameForTypeThrowsExceptionIfTypeIsNotAvailable(): void
    {
        $this->expectException(ModelClassNotFoundException::class);

        $this->subject->getModelClassNameForType('UnknownType');
    }

    #[Test]
    public function getManualsForTypeReturnsManualsCorrectly(): void
    {
        $this->subject->addManualForType('Thing', [Publisher::Google, 'Some text', 'https://example.com/thing']);
        $this->subject->addManualForType('Thing', [Publisher::Yandex, 'Another text', 'https://example.net/thing']);

        $actual = $this->subject->getManualsForType('Thing');

        self::assertCount(2, $actual);
        self::assertSame(Publisher::Google, $actual[0]->publisher);
        self::assertSame('https://example.com/thing', $actual[0]->link);
        self::assertSame(Publisher::Yandex, $actual[1]->publisher);
        self::assertSame('https://example.net/thing', $actual[1]->link);
    }

    #[Test]
    public function getManualsForTypeReturnsEmptyArrayIfTypeNotAvailable(): void
    {
        $actual = $this->subject->getManualsForType('TypeWithNoManuals');

        self::assertSame([], $actual);
    }
}
