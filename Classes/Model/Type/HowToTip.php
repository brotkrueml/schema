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
 * An explanation in the instructions for how to achieve a result. It provides supplementary information about a technique, supply, author\&#039;s preference, etc. It can explain what could be done, or what should not be done, but doesn\&#039;t specify what should be done (see HowToDirection).
 */
final class HowToTip extends AbstractType
{
    protected static $propertyNames = [
        'about',
        'accessMode',
        'accessModeSufficient',
        'accessibilityAPI',
        'accessibilityControl',
        'accessibilityFeature',
        'accessibilityHazard',
        'accessibilitySummary',
        'accountablePerson',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'alternativeHeadline',
        'associatedMedia',
        'audience',
        'audio',
        'author',
        'award',
        'character',
        'citation',
        'comment',
        'commentCount',
        'contentLocation',
        'contentRating',
        'contributor',
        'copyrightHolder',
        'copyrightYear',
        'creator',
        'dateCreated',
        'dateModified',
        'datePublished',
        'description',
        'disambiguatingDescription',
        'discussionUrl',
        'editor',
        'educationalAlignment',
        'educationalUse',
        'encoding',
        'encodingFormat',
        'exampleOfWork',
        'expires',
        'funder',
        'genre',
        'hasPart',
        'headline',
        'identifier',
        'image',
        'inLanguage',
        'interactionStatistic',
        'interactivityType',
        'isAccessibleForFree',
        'isBasedOn',
        'isFamilyFriendly',
        'isPartOf',
        'item',
        'keywords',
        'learningResourceType',
        'license',
        'locationCreated',
        'mainEntity',
        'mainEntityOfPage',
        'material',
        'mentions',
        'name',
        'nextItem',
        'offers',
        'position',
        'potentialAction',
        'previousItem',
        'producer',
        'provider',
        'publication',
        'publisher',
        'publishingPrinciples',
        'recordedAt',
        'releasedEvent',
        'review',
        'sameAs',
        'schemaVersion',
        'sourceOrganization',
        'spatial',
        'spatialCoverage',
        'sponsor',
        'subjectOf',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnailUrl',
        'timeRequired',
        'translator',
        'typicalAgeRange',
        'url',
        'version',
        'video',
        'workExample',
    ];
}
