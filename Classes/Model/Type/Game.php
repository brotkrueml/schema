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
 * The Game type represents things which are games. These are typically rule-governed recreational activities, e.g. role-playing games in which players assume the role of characters in a fictional setting.
 */
#[Type('Game')]
final class Game extends AbstractType
{
    protected static array $propertyNames = [
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
        'characterAttribute',
        'citation',
        'comment',
        'commentCount',
        'contentLocation',
        'contentRating',
        'contributor',
        'copyrightHolder',
        'copyrightYear',
        'countryOfOrigin',
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
        'gameItem',
        'gameLocation',
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
        'keywords',
        'learningResourceType',
        'license',
        'locationCreated',
        'mainEntity',
        'mainEntityOfPage',
        'material',
        'mentions',
        'name',
        'numberOfPlayers',
        'offers',
        'position',
        'potentialAction',
        'producer',
        'publication',
        'publisher',
        'publishingPrinciples',
        'quest',
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
