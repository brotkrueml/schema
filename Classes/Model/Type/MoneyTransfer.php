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
 * The act of transferring money from one place to another place. This may occur electronically or physically.
 */
#[Type('MoneyTransfer')]
final class MoneyTransfer extends AbstractType
{
    protected static array $propertyNames = [
        'actionProcess',
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'amount',
        'beneficiaryBank',
        'description',
        'disambiguatingDescription',
        'endTime',
        'error',
        'fromLocation',
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
        'provider',
        'result',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'toLocation',
        'url',
    ];
}
