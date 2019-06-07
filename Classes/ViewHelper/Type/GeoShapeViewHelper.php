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
 * The geographic shape of a place. A GeoShape can be described using several properties whose values are based on latitude/longitude pairs. Either whitespace or commas can be used to separate latitude and longitude; whitespace should be used when writing a list of several such points.
 *
 * schema.org version 3.6
 */
class GeoShapeViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('address', 'mixed', 'Physical address of the item.');
        $this->registerArgument('addressCountry', 'mixed', 'The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.');
        $this->registerArgument('box', 'mixed', 'A box is the area enclosed by the rectangle formed by two points. The first point is the lower corner, the second point is the upper corner. A box is expressed as two points separated by a space character.');
        $this->registerArgument('circle', 'mixed', 'A circle is the circular region of a specified radius centered at a specified latitude and longitude. A circle is expressed as a pair followed by a radius in meters.');
        $this->registerArgument('elevation', 'mixed', 'The elevation of a location (WGS 84). Values may be of the form \'NUMBER UNITOFMEASUREMENT\' (e.g., \'1,000 m\', \'3,200 ft\') while numbers alone should be assumed to be a value in meters.');
        $this->registerArgument('line', 'mixed', 'A line is a point-to-point path consisting of two or more points. A line is expressed as a series of two or more point objects separated by space.');
        $this->registerArgument('polygon', 'mixed', 'A polygon is the area enclosed by a point-to-point path for which the starting and ending points are the same. A polygon is expressed as a series of four or more space delimited points where the first and final points are identical.');
        $this->registerArgument('postalCode', 'mixed', 'The postal code. For example, 94043.');
    }
}
