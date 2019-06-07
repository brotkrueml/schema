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
 * A rating is an evaluation on a numeric scale, such as 1 to 5 stars.
 *
 * schema.org version 3.6
 */
class RatingViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('author', 'mixed', 'The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.');
        $this->registerArgument('bestRating', 'mixed', 'The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.');
        $this->registerArgument('ratingValue', 'mixed', 'The rating for the content.');
        $this->registerArgument('reviewAspect', 'mixed', 'This Review or Rating is relevant to this part or facet of the itemReviewed.');
        $this->registerArgument('worstRating', 'mixed', 'The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.');
    }
}
