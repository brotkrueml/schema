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
 * A rating is an evaluation on a numeric scale, such as 1 to 5 stars.
 *
 * schema.org version 3.6
 */
class Rating extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('author', 'bestRating', 'ratingValue', 'reviewAspect', 'worstRating');
    }
}
