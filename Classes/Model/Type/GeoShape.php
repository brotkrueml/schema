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
 * The geographic shape of a place. A GeoShape can be described using several properties whose values are based on latitude/longitude pairs. Either whitespace or commas can be used to separate latitude and longitude; whitespace should be used when writing a list of several such points.
 *
 * schema.org version 3.6
 */
class GeoShape extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('address', 'addressCountry', 'box', 'circle', 'elevation', 'line', 'polygon', 'postalCode');
    }
}
