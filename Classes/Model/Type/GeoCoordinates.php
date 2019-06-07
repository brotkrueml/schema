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
 * The geographic coordinates of a place or event.
 *
 * schema.org version 3.6
 */
class GeoCoordinates extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('address', 'addressCountry', 'elevation', 'latitude', 'longitude', 'postalCode');
    }
}
