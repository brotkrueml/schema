<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A GeoCircle is a GeoShape representing a circular geographic area. As it is a GeoShape
 * it provides the simple textual property 'circle', but also allows the combination of postalCode alongside geoRadius.
 * The center of the circle can be indicated via the 'geoMidpoint' property, or more approximately using 'address', 'postalCode'.
 */
final class GeoCircleViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'GeoCircle';
}
