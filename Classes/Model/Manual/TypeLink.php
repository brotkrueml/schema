<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Manual;

/**
 * @internal
 */
final class TypeLink
{
    private readonly string $link;

    public function __construct(
        string $link,
        private readonly string $title,
        private readonly string $iconIdentifier,
    ) {
        $this->checkLink($link);

        $this->link = $link;
    }

    private function checkLink(string $link): void
    {
        if (\filter_var($link, \FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException(
                \sprintf('The given link "%s" ist not a valid URL!', $link),
                1620237735,
            );
        }

        if (! \str_starts_with($link, 'http')) {
            throw new \InvalidArgumentException(
                \sprintf('The given link "%s" ist not a valid web URL!', $link),
                1620237736,
            );
        }
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIconIdentifier(): string
    {
        return $this->iconIdentifier;
    }
}
