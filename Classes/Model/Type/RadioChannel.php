<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A unique instance of a radio BroadcastService on a CableOrSatelliteService lineup.
 */
#[Type('RadioChannel')]
final class RadioChannel extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'broadcastChannelId',
        'broadcastFrequency',
        'broadcastServiceTier',
        'description',
        'disambiguatingDescription',
        'genre',
        'identifier',
        'image',
        'inBroadcastLineup',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'providesBroadcastService',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
