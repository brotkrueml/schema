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
 * The day of the week, e.g. used to specify to which day the opening hours of an OpeningHoursSpecification refer.
 *
 * Originally, URLs from [GoodRelations](http://purl.org/goodrelations/v1) were used (for Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday plus a special entry for PublicHolidays); these have now been integrated directly into schema.org.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum DayOfWeek implements EnumerationInterface
{
    /**
     * The day of the week between Thursday and Saturday.
     */
    case Friday;

    /**
     * The day of the week between Sunday and Tuesday.
     */
    case Monday;

    /**
     * This stands for any day that is a public holiday; it is a placeholder for all official public holidays in some particular location. While not technically a "day of the week", it can be used with OpeningHoursSpecification. In the context of an opening hours specification it can be used to indicate opening hours on public holidays, overriding general opening hours for the day of the week on which a public holiday occurs.
     */
    case PublicHolidays;

    /**
     * The day of the week between Friday and Sunday.
     */
    case Saturday;

    /**
     * The day of the week between Saturday and Monday.
     */
    case Sunday;

    /**
     * The day of the week between Wednesday and Friday.
     */
    case Thursday;

    /**
     * The day of the week between Monday and Wednesday.
     */
    case Tuesday;

    /**
     * The day of the week between Tuesday and Thursday.
     */
    case Wednesday;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
