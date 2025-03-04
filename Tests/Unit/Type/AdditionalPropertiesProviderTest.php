<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Type;

use Brotkrueml\Schema\Tests\Fixtures\Model\AdditionalProperties\Event;
use Brotkrueml\Schema\Tests\Fixtures\Model\AdditionalProperties\Person1;
use Brotkrueml\Schema\Tests\Fixtures\Model\AdditionalProperties\Person2;
use Brotkrueml\Schema\Type\AdditionalPropertiesProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AdditionalPropertiesProvider::class)]
final class AdditionalPropertiesProviderTest extends TestCase
{
    private AdditionalPropertiesProvider $subject;

    protected function setUp(): void
    {
        $this->subject = new AdditionalPropertiesProvider();
    }

    #[Test]
    public function getForTypeReturnsEmptyArrayIfTypeIsNotAvailable(): void
    {
        $actual = $this->subject->getForType('NonExisting');

        self::assertSame([], $actual);
    }

    #[Test]
    public function getForTypeReturnsPreviouslyAddedClassesCorrectly(): void
    {
        $this->subject->add(Person1::class);
        $this->subject->add(Person2::class);
        $this->subject->add(Event::class);

        $actual = $this->subject->getForType('Person');

        self::assertCount(3, $actual);
        self::assertSame('additional-person-property-1', $actual[0]);
        self::assertSame('additional-person-property-2', $actual[1]);
        self::assertSame('additional-person-property-3', $actual[2]);
    }
}
