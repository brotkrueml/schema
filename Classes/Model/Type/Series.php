<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A Series in schema.org is a group of related items, typically but not necessarily of the same kind. See also CreativeWorkSeries, EventSeries.
 *
 * schema.org version 3.6
 */
class Series extends Intangible
{
    public function __construct()
    {
        parent::__construct();
    }
}
