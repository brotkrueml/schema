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
 * Used to describe a seat, such as a reserved seat in an event reservation.
 */
final class Seat extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'seatNumber' => null,
        'seatRow' => null,
        'seatSection' => null,
        'seatingType' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
