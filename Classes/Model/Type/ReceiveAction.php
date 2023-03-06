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
 * The act of physically/electronically taking delivery of an object that has been transferred from an origin to a destination. Reciprocal of SendAction.
 *
 * Related actions:
 * SendAction: The reciprocal of ReceiveAction.
 * TakeAction: Unlike TakeAction, ReceiveAction does not imply that the ownership has been transferred (e.g. I can receive a package, but it does not mean the package is now mine).
 */
#[Type('ReceiveAction')]
final class ReceiveAction extends AbstractType
{
    protected static array $propertyNames = [
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'deliveryMethod',
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
        'participant',
        'potentialAction',
        'result',
        'sameAs',
        'sender',
        'startTime',
        'subjectOf',
        'target',
        'toLocation',
        'url',
    ];
}
