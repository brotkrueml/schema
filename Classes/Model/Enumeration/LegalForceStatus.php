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
 * A list of possible statuses for the legal force of a legislation.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum LegalForceStatus implements EnumerationInterface
{
    /**
     * Indicates that a legislation is in force.
     */
    case InForce;

    /**
     * Indicates that a legislation is currently not in force.
     */
    case NotInForce;

    /**
     * Indicates that parts of the legislation are in force, and parts are not.
     */
    case PartiallyInForce;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
