<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A trip on a commercial train line.
 */
final class TrainTrip extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'arrivalPlatform',
        'arrivalStation',
        'arrivalTime',
        'departurePlatform',
        'departureStation',
        'departureTime',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'offers',
        'potentialAction',
        'provider',
        'sameAs',
        'subjectOf',
        'trainName',
        'trainNumber',
        'url',
    ];
}
