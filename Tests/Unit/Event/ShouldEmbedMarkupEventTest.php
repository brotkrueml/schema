<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

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
