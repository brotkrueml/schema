<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Event;

final class ShouldEmbedMarkupEvent
{
    private array $page = [];
    private bool $embedMarkup = true;

    public function __construct(array $page, bool $embedMarkup)
    {
        $this->page = $page;
        $this->embedMarkup = $embedMarkup;
    }

    public function getPage(): array
    {
        return $this->page;
    }

    public function getEmbedMarkup(): bool
    {
        return $this->embedMarkup;
    }

    public function setEmbedMarkup(bool $embedMarkup): void
    {
        $this->embedMarkup = $embedMarkup;
    }
}
