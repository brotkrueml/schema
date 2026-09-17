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
 * Used to indicate whether a product is EnergyStar certified.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum EnergyStarEnergyEfficiencyEnumeration implements EnumerationInterface
{
    /**
     * Represents EnergyStar certification.
     */
    case EnergyStarCertified;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
