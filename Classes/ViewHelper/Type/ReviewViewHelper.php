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
 * A review of an item - for example, of a restaurant, movie, or store.
 *
 * schema.org version 3.6
 */
class ReviewViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('itemReviewed', 'mixed', 'The item that is being reviewed/rated.');
        $this->registerArgument('reviewAspect', 'mixed', 'This Review or Rating is relevant to this part or facet of the itemReviewed.');
        $this->registerArgument('reviewBody', 'mixed', 'The actual body of the review.');
        $this->registerArgument('reviewRating', 'mixed', 'The rating given in this review. Note that reviews can themselves be rated. The reviewRating applies to rating given by the review. The aggregateRating property applies to the review itself, as a creative work.');
    }
}
