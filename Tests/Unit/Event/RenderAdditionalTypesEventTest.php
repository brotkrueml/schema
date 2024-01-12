<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Event;

use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RenderAdditionalTypesEventTest extends TestCase
{
    private RenderAdditionalTypesEvent $subject;

    protected function setUp(): void
    {
        $this->subject = new RenderAdditionalTypesEvent(false, false);
    }

    #[Test]
    public function isWebPageTypeIsAlreadyDefinedReturnsFalseCorrectly(): void
    {
        self::assertFalse($this->subject->isWebPageTypeAlreadyDefined());
    }

    #[Test]
    public function isWebPageTypeIsAlreadyDefinedReturnsTrueCorrectly(): void
    {
        $subject = new RenderAdditionalTypesEvent(true, false);

        self::assertTrue($subject->isWebPageTypeAlreadyDefined());
    }

    #[Test]
    public function isBreadcrumbListAlreadyDefinedReturnsFalseCorrectly(): void
    {
        self::assertFalse($this->subject->isBreadcrumbListAlreadyDefined());
    }

    #[Test]
    public function isBreadcrumbListAlreadyDefinedReturnsTrueCorrectly(): void
    {
        $subject = new RenderAdditionalTypesEvent(false, true);

        self::assertTrue($subject->isBreadcrumbListAlreadyDefined());
    }

    #[Test]
    public function getAdditionalTypesReturnEmptyArrayWhenNoTypesAreRegistered(): void
    {
        self::assertSame([], $this->subject->getAdditionalTypes());
    }

    #[Test]
    public function addingOneTypeGetAdditionalTypesReturnsTypeCorrectly(): void
    {
        $type = new GenericStub();
        $this->subject->addType($type);

        self::assertSame([$type], $this->subject->getAdditionalTypes());
    }

    #[Test]
    public function addingTwoTypesGetAdditionalTypesReturnsTypesCorrectly(): void
    {
        $type1 = new GenericStub();
        $type2 = new GenericStub();
        $this->subject->addType($type1);
        $this->subject->addType($type2);

        self::assertSame([$type1, $type2], $this->subject->getAdditionalTypes());
    }
}
