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
 * NLNonprofitType: Non-profit organization type originating from the Netherlands.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum NLNonprofitType implements EnumerationInterface
{
    /**
     * NonprofitANBI: Non-profit type referring to a Public Benefit Organization (NL).
     */
    case NonprofitANBI;

    /**
     * NonprofitSBBI: Non-profit type referring to a Social Interest Promoting Institution (NL).
     */
    case NonprofitSBBI;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
