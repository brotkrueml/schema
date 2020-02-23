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
 * A unique instance of a BroadcastService on a CableOrSatelliteService lineup.
 */
final class BroadcastChannel extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'broadcastChannelId' => null,
        'broadcastFrequency' => null,
        'broadcastServiceTier' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'genre' => null,
        'identifier' => null,
        'image' => null,
        'inBroadcastLineup' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'providesBroadcastService' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
