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
 * An agent leaves an event / group with participants/friends at a location.
 *
 * Related actions:
 * JoinAction: The antonym of LeaveAction.
 * UnRegisterAction: Unlike UnRegisterAction, LeaveAction implies leaving a group/team of people rather than a service.
 */
#[Type('LeaveAction')]
final class LeaveAction extends AbstractType
{
    protected static array $propertyNames = [
        'actionProcess',
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'endTime',
        'error',
        'event',
        'identifier',
        'image',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
        'owner',
        'participant',
        'potentialAction',
        'result',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
