<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * Server that provides game interaction in a multiplayer game.
 */
final class GameServer extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'game',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'playersOnline',
        'potentialAction',
        'sameAs',
        'serverStatus',
        'subjectOf',
        'url',
    ];
}
