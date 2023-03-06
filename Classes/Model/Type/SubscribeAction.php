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
 * The act of forming a personal connection with someone/something (object) unidirectionally/asymmetrically to get updates pushed to.
 *
 * Related actions:
 * FollowAction: Unlike FollowAction, SubscribeAction implies that the subscriber acts as a passive agent being constantly/actively pushed for updates.
 * RegisterAction: Unlike RegisterAction, SubscribeAction implies that the agent is interested in continuing receiving updates from the object.
 * JoinAction: Unlike JoinAction, SubscribeAction implies that the agent is interested in continuing receiving updates from the object.
 */
#[Type('SubscribeAction')]
final class SubscribeAction extends AbstractType
{
    protected static array $propertyNames = [
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'endTime',
        'error',
        'identifier',
        'image',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
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
