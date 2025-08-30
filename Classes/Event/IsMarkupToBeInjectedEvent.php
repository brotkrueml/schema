<?php

declare(strict_types=1);


namespace Brotkrueml\Schema\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @api
 */
final class IsMarkupToBeInjectedEvent  implements StoppableEventInterface
{
    private bool $isMarkupToBeInjected = true;

    public function __construct(
        private readonly ServerRequestInterface $request
    ) {}

    public function excludeMarkupFromInjection(): void
    {
        $this->isMarkupToBeInjected = false;
    }

    public function isMarkupToBeInjected(): bool
    {
        return $this->isMarkupToBeInjected;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function isPropagationStopped(): bool
    {
        return !$this->isMarkupToBeInjected();
    }
}
