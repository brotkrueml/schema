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
 * The geographic coordinates of a place or event.
 *
 * schema.org version 3.6
 */
class GeoCoordinatesViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('address', 'mixed', 'Physical address of the item.');
        $this->registerArgument('addressCountry', 'mixed', 'The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.');
        $this->registerArgument('elevation', 'mixed', 'The elevation of a location (WGS 84). Values may be of the form \'NUMBER UNITOFMEASUREMENT\' (e.g., \'1,000 m\', \'3,200 ft\') while numbers alone should be assumed to be a value in meters.');
        $this->registerArgument('latitude', 'mixed', 'The latitude of a location. For example 37.42242 (WGS 84).');
        $this->registerArgument('longitude', 'mixed', 'The longitude of a location. For example -122.08585 (WGS 84).');
        $this->registerArgument('postalCode', 'mixed', 'The postal code. For example, 94043.');
    }
}
