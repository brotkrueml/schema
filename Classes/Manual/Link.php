<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Manual;

/**
 * @internal
 */
final readonly class Link
{
    public string $link;

    public function __construct(
        string $link,
        public string $title,
        public string $iconIdentifier,
        public string $alternative = '',
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
}
