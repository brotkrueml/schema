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
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use PHPUnit\Framework\TestCase;

class RegisterAdditionalTypePropertiesEventTest extends TestCase
{
    /**
     * @var RegisterAdditionalTypePropertiesEvent
     */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new RegisterAdditionalTypePropertiesEvent(FixtureThing::class);
    }

    /**
     * @test
     */
    public function getTypeReturnsTheTypeCorrectly(): void
    {
        self::assertSame(FixtureThing::class, $this->subject->getType());
    }

    /**
     * @test
     */
    public function additionalPropertiesIsInitiallyEmpty(): void
    {
        self::assertCount(0, $this->subject->getAdditionalProperties());
    }

    /**
     * @test
     */
    public function registerAdditionalPropertyAddsPropertyToList(): void
    {
        $this->subject->registerAdditionalProperty('someAdditionalProperty');
        $this->subject->registerAdditionalProperty('anotherAdditionalProperty');

        self::assertCount(2, $this->subject->getAdditionalProperties());
        self::assertContains('someAdditionalProperty', $this->subject->getAdditionalProperties());
        self::assertContains('anotherAdditionalProperty', $this->subject->getAdditionalProperties());
    }

    /**
     * @test
     */
    public function alreadyExistingAdditionalPropertyIsNotRegisteredAgain(): void
    {
        $this->subject->registerAdditionalProperty('someProperty');
        $this->subject->registerAdditionalProperty('someProperty');

        self::assertSame(['someProperty'], $this->subject->getAdditionalProperties());
    }
}
