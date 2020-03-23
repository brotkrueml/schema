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
 * Represents additional information about a relationship or property. For example a Role can be used to say that a \&#039;member\&#039; role linking some SportsTeam to a player occurred during a particular time period. Or that a Person\&#039;s \&#039;actor\&#039; role in a Movie was for some particular characterName. Such properties can be attached to a Role entity, which is then associated with the main entities using ordinary properties like \&#039;member\&#039; or \&#039;actor\&#039;.
 */
final class Role extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'endDate',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'roleName',
        'sameAs',
        'startDate',
        'subjectOf',
        'url',
    ];
}
