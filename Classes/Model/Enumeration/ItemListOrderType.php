<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * Enumerated for values for itemListOrder for indicating how an ordered ItemList is organized.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum ItemListOrderType implements EnumerationInterface
{
    /**
     * An ItemList ordered with lower values listed first.
     */
    case ItemListOrderAscending;

    /**
     * An ItemList ordered with higher values listed first.
     */
    case ItemListOrderDescending;

    /**
     * An ItemList ordered with no explicit order.
     */
    case ItemListUnordered;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
