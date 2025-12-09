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
 * The act of notifying someone of information pertinent to them, with no expectation of a response.
 */
#[Type('InformAction')]
final class InformAction extends AbstractType
{
    protected static array $propertyNames = [
        'about',
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
        'inLanguage',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
        'owner',
        'participant',
        'potentialAction',
        'recipient',
        'result',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
