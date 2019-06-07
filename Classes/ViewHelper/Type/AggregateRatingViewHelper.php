<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * The average rating based on multiple ratings or reviews.
 *
 * schema.org version 3.6
 */
class AggregateRatingViewHelper extends RatingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('itemReviewed', 'mixed', 'The item that is being reviewed/rated.');
        $this->registerArgument('ratingCount', 'mixed', 'The count of total number of ratings.');
        $this->registerArgument('reviewCount', 'mixed', 'The count of total number of reviews.');
    }
}
