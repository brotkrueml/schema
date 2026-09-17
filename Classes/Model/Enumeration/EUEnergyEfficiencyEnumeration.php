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
 * Enumerates the EU energy efficiency classes A-G as well as A+, A++, and A+++ as defined in EU directive 2017/1369.
 */
enum EUEnergyEfficiencyEnumeration implements EnumerationInterface
{
    /**
     * Represents EU Energy Efficiency Class A as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryA;

    /**
     * Represents EU Energy Efficiency Class A+ as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryA1Plus;

    /**
     * Represents EU Energy Efficiency Class A++ as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryA2Plus;

    /**
     * Represents EU Energy Efficiency Class A+++ as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryA3Plus;

    /**
     * Represents EU Energy Efficiency Class B as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryB;

    /**
     * Represents EU Energy Efficiency Class C as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryC;

    /**
     * Represents EU Energy Efficiency Class D as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryD;

    /**
     * Represents EU Energy Efficiency Class E as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryE;

    /**
     * Represents EU Energy Efficiency Class F as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryF;

    /**
     * Represents EU Energy Efficiency Class G as defined in EU energy labeling regulations.
     */
    case EUEnergyEfficiencyCategoryG;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
