<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Event;

use Brotkrueml\Schema\Event\IsMarkupToBeInjectedEvent;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(IsMarkupToBeInjectedEvent::class)]
final class IsMarkupToBeInjectedEventTest extends TestCase
{
    private Stub $requestStub;
    private IsMarkupToBeInjectedEvent $subject;

    protected function setUp(): void
    {
        $this->requestStub = self::createStub(ServerRequestInterface::class);
        $this->subject = new IsMarkupToBeInjectedEvent($this->requestStub);
    }

    #[Test]
    public function getRequestReturnsRequestCorrectly(): void
    {
        self::assertSame($this->requestStub, $this->subject->getRequest());
    }

    #[Test]
    public function isMarkupToBeInjectedReturnsTrueIfNotExcluded(): void
    {
        self::assertTrue($this->subject->isMarkupToBeInjected());
    }

    #[Test]
    public function isMarkupToBeInjectedReturnsFalseIfExcludeMarkupFromInjectionHasBeenCalled(): void
    {
        $this->subject->excludeMarkupFromInjection();

        self::assertFalse($this->subject->isMarkupToBeInjected());
    }

    #[Test]
    public function isPropagationStoppedReturnsFalseIfMarkupIsNotExcluded(): void
    {
        self::assertFalse($this->subject->isPropagationStopped());
    }

    #[Test]
    public function isPropagationStoppedReturnsTrueIfExcludeMarkupFromInjectionHasBeenCalled(): void
    {
        $this->subject->excludeMarkupFromInjection();

        self::assertTrue($this->subject->isPropagationStopped());
    }
}
