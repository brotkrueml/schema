<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Exception;

final class MissingBreadcrumbArgumentException extends \DomainException
{
    /**
     * @param list<array<string, mixed>> $breadcrumb
     */
    public static function fromMissingTitle(array $breadcrumb): self
    {
        return new self(
            \sprintf(
                'An item in the given breadcrumb structure does not have the "title" key, given: %s',
                \json_encode($breadcrumb, \JSON_THROW_ON_ERROR),
            ),
            1561890280,
        );
    }

    /**
     * @param list<array<string, mixed>> $breadcrumb
     */
    public static function fromMissingLink(array $breadcrumb): self
    {
        return new self(
            \sprintf(
                'An item in the given breadcrumb structure does not have the "link" key, given: %s',
                \json_encode($breadcrumb, \JSON_THROW_ON_ERROR),
            ),
            1561890281,
        );
    }
}
