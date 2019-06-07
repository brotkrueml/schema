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
 * Specifies a location feature by providing a structured value representing a feature of an accommodation as a property-value pair of varying degrees of formality.
 *
 * schema.org version 3.6
 */
class LocationFeatureSpecificationViewHelper extends PropertyValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('hoursAvailable', 'mixed', 'The hours during which this service or contact is available.');
        $this->registerArgument('validFrom', 'mixed', 'The date when the item becomes valid.');
        $this->registerArgument('validThrough', 'mixed', 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.');
    }
}
