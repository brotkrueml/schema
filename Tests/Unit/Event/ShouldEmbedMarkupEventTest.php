<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Event;

use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use PHPUnit\Framework\TestCase;

class ShouldEmbedMarkupEventTest extends TestCase
{
    /**
     * @test
     */
    public function getPageReceivesThePageCorrectly(): void
    {
        $subject = new ShouldEmbedMarkupEvent(['uid' => 42], true);

        self::assertSame(['uid' => 42], $subject->getPage());
    }

    /**
     * @test
     */
    public function setAndGetEmbedMarkupAreImplementedCorrectly(): void
    {
        $subject = new ShouldEmbedMarkupEvent([], true);

        self::assertTrue($subject->getEmbedMarkup());

        $subject->setEmbedMarkup(false);

        self::assertFalse($subject->getEmbedMarkup());
    }
}
