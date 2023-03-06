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
 * The act of posing a question / favor to someone.
 *
 * Related actions:
 * ReplyAction: Appears generally as a response to AskAction.
 */
#[Type('AskAction')]
final class AskAction extends AbstractType
{
    protected static array $propertyNames = [
        'about',
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
        'inLanguage',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
        'participant',
        'potentialAction',
        'question',
        'recipient',
        'result',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
