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
 * The act of asserting that a future event/action is no longer going to happen.
 *
 * Related actions:
 * ConfirmAction: The antonym of CancelAction.
 */
#[Type('CancelAction')]
final class CancelAction extends AbstractType
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
        'scheduledTime',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
