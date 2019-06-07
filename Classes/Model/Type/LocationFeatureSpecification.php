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
 * Specifies a location feature by providing a structured value representing a feature of an accommodation as a property-value pair of varying degrees of formality.
 *
 * schema.org version 3.6
 */
class LocationFeatureSpecification extends PropertyValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('hoursAvailable', 'validFrom', 'validThrough');
    }
}
