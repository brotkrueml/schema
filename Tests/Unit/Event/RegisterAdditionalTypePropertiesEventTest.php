<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Event;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegisterAdditionalTypePropertiesEvent::class)]
final class RegisterAdditionalTypePropertiesEventTest extends TestCase
{
    private RegisterAdditionalTypePropertiesEvent $subject;

    protected function setUp(): void
    {
        $this->subject = new RegisterAdditionalTypePropertiesEvent(Thing::class);
    }

    #[Test]
    public function getTypeReturnsTheTypeCorrectly(): void
    {
        self::assertSame(Thing::class, $this->subject->getType());
    }

    #[Test]
    public function additionalPropertiesIsInitiallyEmpty(): void
    {
        self::assertCount(0, $this->subject->getAdditionalProperties());
    }

    #[Test]
    public function registerAdditionalPropertyAddsPropertyToList(): void
    {
        $this->subject->registerAdditionalProperty('someAdditionalProperty');
        $this->subject->registerAdditionalProperty('anotherAdditionalProperty');

        self::assertCount(2, $this->subject->getAdditionalProperties());
        self::assertContains('someAdditionalProperty', $this->subject->getAdditionalProperties());
        self::assertContains('anotherAdditionalProperty', $this->subject->getAdditionalProperties());
    }

    #[Test]
    public function alreadyExistingAdditionalPropertyIsNotRegisteredAgain(): void
    {
        $this->subject->registerAdditionalProperty('someProperty');
        $this->subject->registerAdditionalProperty('someProperty');

        self::assertSame(['someProperty'], $this->subject->getAdditionalProperties());
    }

    #[Test]
    public function haveAdditionalPropertiesChangedReturnsFalseIfNoAdditionalPropertiesHaveBeenRegistered(): void
    {
        $actual = $this->subject->haveAdditionalPropertiesRegistered();

        self::assertFalse($actual);
    }

    #[Test]
    public function haveAdditionalPropertiesChangedReturnsTrueIfAdditionalPropertiesHaveBeenRegistered(): void
    {
        $this->subject->registerAdditionalProperty('someProperty');

        $actual = $this->subject->haveAdditionalPropertiesRegistered();

        self::assertTrue($actual);
    }
}
