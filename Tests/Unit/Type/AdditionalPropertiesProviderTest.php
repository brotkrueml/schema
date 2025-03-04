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
    public function getReturnsEmptyArrayIfTypeIsNotAvailable(): void
    {
        $actual = $this->subject->get('NonExisting');

        self::assertSame([], $actual);
    }

    #[Test]
    public function getReturnsPreviouslyAddedClassesCorrectly(): void
    {
        $this->subject->add(Person1::class);
        $this->subject->add(Person2::class);
        $this->subject->add(Event::class);

        $actual = $this->subject->get('Person');

        self::assertCount(2, $actual);
        self::assertContains(Person1::class, $actual);
        self::assertContains(Person2::class, $actual);
    }
}
