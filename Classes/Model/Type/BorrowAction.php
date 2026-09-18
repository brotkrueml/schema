<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * The act of obtaining an object under an agreement to return it at a later date. Reciprocal of LendAction.
 *
 * Related actions:
 * LendAction: Reciprocal of BorrowAction.
 */
#[Type('BorrowAction')]
#[Manual(Publisher::Google, 'Book actions', 'https://developers.google.com/search/docs/appearance/structured-data/book#borrowaction-potentialaction')]
final class BorrowAction extends AbstractType
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
        'fromLocation',
        'identifier',
        'image',
        'instrument',
        'lender',
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
