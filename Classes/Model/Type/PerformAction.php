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
 * The act of participating in performance arts.
 */
#[Type('PerformAction')]
final class PerformAction extends AbstractType
{
    protected static $propertyNames = [
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'audience',
        'description',
        'disambiguatingDescription',
        'endTime',
        'entertainmentBusiness',
        'error',
        'event',
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
