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
 * A GeoCircle is a GeoShape representing a circular geographic area. As it is a GeoShape
 *
 * schema.org version 3.6
 */
class GeoCircleViewHelper extends GeoShapeViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('geoMidpoint', 'mixed', 'Indicates the GeoCoordinates at the centre of a GeoShape e.g. GeoCircle.');
        $this->registerArgument('geoRadius', 'mixed', 'Indicates the approximate radius of a GeoCircle (metres unless indicated otherwise via Distance notation).');
    }
}
