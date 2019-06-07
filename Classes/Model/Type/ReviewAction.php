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
 * The act of producing a balanced opinion about the object for an audience. An agent reviews an object with participants resulting in a review.
 *
 * schema.org version 3.6
 */
class ReviewAction extends AssessAction
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('resultReview');
    }
}
