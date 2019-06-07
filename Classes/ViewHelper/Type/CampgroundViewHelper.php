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
 * A camping site, campsite, or Campground is a place used for overnight stay in the outdoors, typically containing individual CampingPitch locations.
 *
 * schema.org version 3.6
 */
class CampgroundViewHelper extends CivicStructureViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('amenityFeature', 'mixed', 'An amenity feature (e.g. a characteristic or service) of the Accommodation. This generic property does not make a statement about whether the feature is included in an offer for the main accommodation or available at extra costs.');
        $this->registerArgument('audience', 'mixed', 'An intended audience, i.e. a group for whom something was created.');
        $this->registerArgument('availableLanguage', 'mixed', 'A language someone may use with or at the item, service or place. Please use one of the language codes from the IETF BCP 47 standard. See also inLanguage');
        $this->registerArgument('checkinTime', 'mixed', 'The earliest someone may check into a lodging establishment.');
        $this->registerArgument('checkoutTime', 'mixed', 'The latest someone may check out of a lodging establishment.');
        $this->registerArgument('numberOfRooms', 'mixed', 'The number of rooms (excluding bathrooms and closets) of the accommodation or lodging business.');
        $this->registerArgument('petsAllowed', 'mixed', 'Indicates whether pets are allowed to enter the accommodation or lodging business. More detailed information can be put in a text value.');
        $this->registerArgument('starRating', 'mixed', 'An official rating for a lodging business or food establishment, e.g. from national associations or standards bodies. Use the author property to indicate the rating organization, e.g. as an Organization with name such as (e.g. HOTREC, DEHOGA, WHR, or Hotelstars).');
    }
}
