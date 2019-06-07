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
 * Entities that have a somewhat fixed, physical extension.
 *
 * schema.org version 3.6
 */
class Place extends Thing
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('additionalProperty', 'address', 'aggregateRating', 'amenityFeature', 'branchCode', 'containedInPlace', 'containsPlace', 'event', 'faxNumber', 'geo', 'geoContains', 'geoCoveredBy', 'geoCovers', 'geoCrosses', 'geoDisjoint', 'geoEquals', 'geoIntersects', 'geoOverlaps', 'geoTouches', 'geoWithin', 'globalLocationNumber', 'hasMap', 'isAccessibleForFree', 'isicV4', 'logo', 'maximumAttendeeCapacity', 'openingHoursSpecification', 'photo', 'publicAccess', 'review', 'slogan', 'smokingAllowed', 'specialOpeningHoursSpecification', 'telephone');
    }
}
