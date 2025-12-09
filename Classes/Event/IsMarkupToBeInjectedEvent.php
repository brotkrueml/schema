<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @api
 */
final class IsMarkupToBeInjectedEvent implements StoppableEventInterface
{
    private bool $isMarkupToBeInjected = true;

    public function __construct(
        private readonly ServerRequestInterface $request,
    ) {}

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function excludeMarkupFromInjection(): void
    {
        $this->isMarkupToBeInjected = false;
    }

    public function isMarkupToBeInjected(): bool
    {
        return $this->isMarkupToBeInjected;
    }

    public function isPropagationStopped(): bool
    {
        return ! $this->isMarkupToBeInjected();
    }
}
