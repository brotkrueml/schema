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
 * GovernmentBenefitsType enumerates several kinds of government benefits to support the COVID-19 situation. Note that this structure may not capture all benefits offered.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum GovernmentBenefitsType implements EnumerationInterface
{
    /**
     * BasicIncome: this is a benefit for basic income.
     */
    case BasicIncome;

    /**
     * BusinessSupport: this is a benefit for supporting businesses.
     */
    case BusinessSupport;

    /**
     * DisabilitySupport: this is a benefit for disability support.
     */
    case DisabilitySupport;

    /**
     * HealthCare: this is a benefit for health care.
     */
    case HealthCare;

    /**
     * OneTimePayments: this is a benefit for one-time payments for individuals.
     */
    case OneTimePayments;

    /**
     * PaidLeave: this is a benefit for paid leave.
     */
    case PaidLeave;

    /**
     * ParentalSupport: this is a benefit for parental support.
     */
    case ParentalSupport;

    /**
     * UnemploymentSupport: this is a benefit for unemployment support.
     */
    case UnemploymentSupport;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
