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
 * A radio channel that uses FM.
 */
final class FMRadioChannel extends AbstractType
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
