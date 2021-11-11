<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Manager;

use Brotkrueml\Schema\Manager\MainEntityOfWebPageBag;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use PHPUnit\Framework\TestCase;

final class MainEntityOfWebPageBagTest extends TestCase
{
    private MainEntityOfWebPageBag $subject;

    protected function setUp(): void
    {
        $this->subject = new MainEntityOfWebPageBag();
    }

    /**
     * @test
     */
    public function bagIsEmptyAfterInstantiation(): void
    {
        self::assertCount(0, $this->subject);
        self::assertSame([], $this->subject->getTypes());
    }

    /**
     * @test
     */
    public function bagContainsOneTypeWhenOneNotPrioritisedTypeIsAdded(): void
    {
        $type = new GenericStub();
        $notPrioritisedTypes = $this->subject->add($type, false);

        self::assertCount(1, $this->subject);
        self::assertSame([$type], $this->subject->getTypes());
        self::assertSame([], $notPrioritisedTypes);
    }

    /**
     * @test
     */
    public function bagContainsTwoTypesWhenTwoNotPrioritisedTypesAreAdded(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $this->subject->add($type1, false);
        $notPrioritisedTypes = $this->subject->add($type2, false);

        self::assertCount(2, $this->subject);
        self::assertContains($type1, $this->subject->getTypes());
        self::assertContains($type2, $this->subject->getTypes());
        self::assertSame([], $notPrioritisedTypes);
    }

    /**
     * @test
     */
    public function bagContainsOneTypeWhenOnePrioritisedTypeIsAdded(): void
    {
        $type = new GenericStub();
        $notPrioritisedTypes = $this->subject->add($type, true);

        self::assertCount(1, $this->subject);
        self::assertSame([$type], $this->subject->getTypes());
        self::assertSame([], $notPrioritisedTypes);
    }

    /**
     * @test
     */
    public function bagContainsTwoTypesWhenTwoPrioritisedTypesAreAdded(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $this->subject->add($type1, true);
        $notPrioritisedTypes = $this->subject->add($type2, true);

        self::assertCount(2, $this->subject);
        self::assertContains($type1, $this->subject->getTypes());
        self::assertContains($type2, $this->subject->getTypes());
        self::assertSame([], $notPrioritisedTypes);
    }

    /**
     * @test
     */
    public function bagContainsOnePrioritisedTypeWhenOneNotPrioritisedTypeAndThenOnePrioritisedTypeIsAdded(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $this->subject->add($type1, false);
        $notPrioritisedTypes = $this->subject->add($type2, true);

        self::assertCount(1, $this->subject);
        self::assertSame([$type2], $this->subject->getTypes());
        self::assertSame([$type1], $notPrioritisedTypes);
    }

    /**
     * @test
     */
    public function bagContainsOnePrioritisedTypeWhenOnePrioritisedTypeAndThenOneNotPrioritisedTypeIsAdded(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $this->subject->add($type1, true);
        $notPrioritisedTypes = $this->subject->add($type2, false);

        self::assertCount(1, $this->subject);
        self::assertSame([$type1], $this->subject->getTypes());
        self::assertSame([$type2], $notPrioritisedTypes);
    }

    /**
     * @test
     */
    public function bagContainsCorrectPrioritisedTypesWhenPrioritisedAndNotPrioritisedTypesAreAdded(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $type3 = new GenericStub();
        $type4 = new GenericStub();
        $type5 = new GenericStub();
        $notPrioritisedTypes = [];
        $notPrioritisedTypes = \array_merge($notPrioritisedTypes, $this->subject->add($type1, false));
        $notPrioritisedTypes = \array_merge($notPrioritisedTypes, $this->subject->add($type2, false));
        $notPrioritisedTypes = \array_merge($notPrioritisedTypes, $this->subject->add($type3, true));
        $notPrioritisedTypes = \array_merge($notPrioritisedTypes, $this->subject->add($type4, false));
        $notPrioritisedTypes = \array_merge($notPrioritisedTypes, $this->subject->add($type5, true));

        self::assertCount(2, $this->subject);
        self::assertContains($type1, $notPrioritisedTypes);
        self::assertContains($type2, $notPrioritisedTypes);
        self::assertContains($type3, $this->subject->getTypes());
        self::assertContains($type4, $notPrioritisedTypes);
        self::assertContains($type5, $this->subject->getTypes());
    }
}
