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
 * A video game series.
 */
final class VideoGameSeries extends AbstractType
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
        'actor',
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
        'cheatCode',
        'citation',
        'comment',
        'commentCount',
        'containsSeason',
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
        'director',
        'disambiguatingDescription',
        'discussionUrl',
        'editor',
        'educationalAlignment',
        'educationalUse',
        'encoding',
        'encodingFormat',
        'endDate',
        'episode',
        'exampleOfWork',
        'expires',
        'funder',
        'gameItem',
        'gameLocation',
        'gamePlatform',
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
        'issn',
        'keywords',
        'learningResourceType',
        'license',
        'locationCreated',
        'mainEntity',
        'mainEntityOfPage',
        'material',
        'mentions',
        'musicBy',
        'name',
        'numberOfEpisodes',
        'numberOfPlayers',
        'numberOfSeasons',
        'offers',
        'playMode',
        'position',
        'potentialAction',
        'producer',
        'productionCompany',
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
        'startDate',
        'subjectOf',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnail',
        'thumbnailUrl',
        'timeRequired',
        'trailer',
        'translator',
        'typicalAgeRange',
        'url',
        'version',
        'video',
        'workExample',
    ];
}
