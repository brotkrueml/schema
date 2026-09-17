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
 * UKNonprofitType: Non-profit organization type originating from the United Kingdom.
 */
enum UKNonprofitType implements EnumerationInterface
{
    /**
     * CharitableIncorporatedOrganization: Non-profit type referring to a Charitable Incorporated Organization (UK).
     */
    case CharitableIncorporatedOrganization;

    /**
     * LimitedByGuaranteeCharity: Non-profit type referring to a charitable company that is limited by guarantee (UK).
     */
    case LimitedByGuaranteeCharity;

    /**
     * UKTrust: Non-profit type referring to a UK trust.
     */
    case UKTrust;

    /**
     * UnincorporatedAssociationCharity: Non-profit type referring to a charitable company that is not incorporated (UK).
     */
    case UnincorporatedAssociationCharity;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
