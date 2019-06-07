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
 * A brand is a name used by an organization or business person for labeling a product, product group, or similar.
 *
 * schema.org version 3.6
 */
class BrandViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('aggregateRating', 'mixed', 'The overall rating, based on a collection of reviews or ratings, of the item.');
        $this->registerArgument('logo', 'mixed', 'An associated logo.');
        $this->registerArgument('review', 'mixed', 'A review of the item.');
        $this->registerArgument('slogan', 'mixed', 'A slogan or motto associated with the item.');
    }
}
