<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * The act of responding to a question/message asked/sent by the object. Related to AskAction
 *
 * Related actions:
 * AskAction: Appears generally as an origin of a ReplyAction.
 */
final class ReplyAction extends AbstractType
{
    protected static $propertyNames = [
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
        'recipient',
        'result',
        'resultComment',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
