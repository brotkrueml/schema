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
 * Entities that have a somewhat fixed, physical extension.
 *
 * schema.org version 3.6
 */
class PlaceViewHelper extends ThingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalProperty', 'mixed', 'A property-value pair representing an additional characteristics of the entitity, e.g. a product feature or another characteristic for which there is no matching property in schema.org.');
        $this->registerArgument('address', 'mixed', 'Physical address of the item.');
        $this->registerArgument('aggregateRating', 'mixed', 'The overall rating, based on a collection of reviews or ratings, of the item.');
        $this->registerArgument('amenityFeature', 'mixed', 'An amenity feature (e.g. a characteristic or service) of the Accommodation. This generic property does not make a statement about whether the feature is included in an offer for the main accommodation or available at extra costs.');
        $this->registerArgument('branchCode', 'mixed', 'A short textual code (also called "store code") that uniquely identifies a place of business. The code is typically assigned by the parentOrganization and used in structured URLs.');
        $this->registerArgument('containedInPlace', 'mixed', 'The basic containment relation between a place and one that contains it.');
        $this->registerArgument('containsPlace', 'mixed', 'The basic containment relation between a place and another that it contains.');
        $this->registerArgument('event', 'mixed', 'Upcoming or past event associated with this place, organization, or action.');
        $this->registerArgument('faxNumber', 'mixed', 'The fax number.');
        $this->registerArgument('geo', 'mixed', 'The geo coordinates of the place.');
        $this->registerArgument('geoContains', 'mixed', 'Represents a relationship between two geometries (or the places they represent), relating a containing geometry to a contained geometry. "a contains b iff no points of b lie in the exterior of a, and at least one point of the interior of b lies in the interior of a". As defined in DE-9IM.');
        $this->registerArgument('geoCoveredBy', 'mixed', 'Represents a relationship between two geometries (or the places they represent), relating a geometry to another that covers it. As defined in DE-9IM.');
        $this->registerArgument('geoCovers', 'mixed', 'Represents a relationship between two geometries (or the places they represent), relating a covering geometry to a covered geometry. "Every point of b is a point of (the interior or boundary of) a". As defined in DE-9IM.');
        $this->registerArgument('geoCrosses', 'mixed', 'Represents a relationship between two geometries (or the places they represent), relating a geometry to another that crosses it: "a crosses b: they have some but not all interior points in common, and the dimension of the intersection is less than that of at least one of them". As defined in DE-9IM.');
        $this->registerArgument('geoDisjoint', 'mixed', 'Represents spatial relations in which two geometries (or the places they represent) are topologically disjoint: they have no point in common. They form a set of disconnected geometries." (a symmetric relationship, as defined in DE-9IM)');
        $this->registerArgument('geoEquals', 'mixed', 'Represents spatial relations in which two geometries (or the places they represent) are topologically equal, as defined in DE-9IM. "Two geometries are topologically equal if their interiors intersect and no part of the interior or boundary of one geometry intersects the exterior of the other" (a symmetric relationship)');
        $this->registerArgument('geoIntersects', 'mixed', 'Represents spatial relations in which two geometries (or the places they represent) have at least one point in common. As defined in DE-9IM.');
        $this->registerArgument('geoOverlaps', 'mixed', 'Represents a relationship between two geometries (or the places they represent), relating a geometry to another that geospatially overlaps it, i.e. they have some but not all points in common. As defined in DE-9IM.');
        $this->registerArgument('geoTouches', 'mixed', 'Represents spatial relations in which two geometries (or the places they represent) touch: they have at least one boundary point in common, but no interior points." (a symmetric relationship, as defined in DE-9IM )');
        $this->registerArgument('geoWithin', 'mixed', 'Represents a relationship between two geometries (or the places they represent), relating a geometry to one that contains it, i.e. it is inside (i.e. within) its interior. As defined in DE-9IM.');
        $this->registerArgument('globalLocationNumber', 'mixed', 'The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.');
        $this->registerArgument('hasMap', 'mixed', 'A URL to a map of the place.');
        $this->registerArgument('isAccessibleForFree', 'mixed', 'A flag to signal that the item, event, or place is accessible for free.');
        $this->registerArgument('isicV4', 'mixed', 'The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.');
        $this->registerArgument('logo', 'mixed', 'An associated logo.');
        $this->registerArgument('maximumAttendeeCapacity', 'mixed', 'The total number of individuals that may attend an event or venue.');
        $this->registerArgument('openingHoursSpecification', 'mixed', 'The opening hours of a certain place.');
        $this->registerArgument('photo', 'mixed', 'A photograph of this place.');
        $this->registerArgument('publicAccess', 'mixed', 'A flag to signal that the Place is open to public visitors.  If this property is omitted there is no assumed default boolean value');
        $this->registerArgument('review', 'mixed', 'A review of the item.');
        $this->registerArgument('slogan', 'mixed', 'A slogan or motto associated with the item.');
        $this->registerArgument('smokingAllowed', 'mixed', 'Indicates whether it is allowed to smoke in the place, e.g. in the restaurant, hotel or hotel room.');
        $this->registerArgument('specialOpeningHoursSpecification', 'mixed', 'The special opening hours of a certain place.');
        $this->registerArgument('telephone', 'mixed', 'The telephone number.');
    }
}
