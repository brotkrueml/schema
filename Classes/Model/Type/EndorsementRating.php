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
 * An EndorsementRating is a rating that expresses some level of endorsement, for example inclusion in a "critic\'s pick" blog, a
 *
 * schema.org version 3.6
 */
class EndorsementRating extends Rating
{
    public function __construct()
    {
        parent::__construct();
    }
}
