<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Event;

use Brotkrueml\Schema\Event\InitialiseTypesEvent;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class InitialiseTypesEventTest extends TestCase
{
    private InitialiseTypesEvent $subject;

    protected function setUp(): void
    {
        $this->subject = new InitialiseTypesEvent();
    }

    #[Test]
    public function getTypesReturnEmptyArrayWhenNoTypeWasAdded(): void
    {
        $actual = $this->subject->getTypes();

        self::assertSame([], $actual);
    }

    #[Test]
    public function getTypesReturnsTheTypeIfOneTypeWasAdded(): void
    {
        $type = new GenericStub();
        $this->subject->addType($type);

        $actual = $this->subject->getTypes();

        self::assertCount(1, $actual);
        self::assertSame($type, $actual[0]);
    }

    #[Test]
    public function getTypesReturnsTheTypesIfTwoTypesWereAdded(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $this->subject->addType($type1);
        $this->subject->addType($type2);

        $actual = $this->subject->getTypes();

        self::assertCount(2, $actual);
        self::assertSame($type1, $actual[0]);
        self::assertSame($type2, $actual[1]);
    }
}
