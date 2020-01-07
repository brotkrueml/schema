<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Event;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

final class ShouldEmbedMarkupEvent
{
    /**
     * @var array
     */
    private $page = [];

    /**
     * @var bool
     */
    private $embedMarkup = true;

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
