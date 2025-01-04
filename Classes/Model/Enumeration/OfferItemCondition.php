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
 * A list of possible conditions for the item.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum OfferItemCondition implements EnumerationInterface
{
    /**
     * Indicates that the item is damaged.
     */
    case DamagedCondition;

    /**
     * Indicates that the item is new.
     */
    case NewCondition;

    /**
     * Indicates that the item is refurbished.
     */
    case RefurbishedCondition;

    /**
     * Indicates that the item is used.
     */
    case UsedCondition;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
