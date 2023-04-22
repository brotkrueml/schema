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
 * A video file.
 */
#[Type('VideoObject')]
#[Manual(Publisher::Google, 'https://developers.google.com/search/docs/data-types/video')]
#[Manual(Publisher::Yandex, 'https://yandex.com/support/video/partners/schema-org.html')]
final class VideoObject extends AbstractType
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
        'actor',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'alternativeHeadline',
        'associatedArticle',
        'associatedMedia',
        'audience',
        'audio',
        'author',
        'award',
        'bitrate',
        'caption',
        'character',
        'citation',
        'comment',
        'commentCount',
        'contentLocation',
        'contentRating',
        'contentSize',
        'contentUrl',
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
        'duration',
        'editor',
        'educationalAlignment',
        'educationalUse',
        'embedUrl',
        'encodesCreativeWork',
        'encoding',
        'encodingFormat',
        'endTime',
        'exampleOfWork',
        'expires',
        'funder',
        'genre',
        'hasPart',
        'headline',
        'height',
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
        'musicBy',
        'name',
        'offers',
        'playerType',
        'position',
        'potentialAction',
        'producer',
        'productionCompany',
        'publication',
        'publisher',
        'publishingPrinciples',
        'recordedAt',
        'regionsAllowed',
        'releasedEvent',
        'requiresSubscription',
        'review',
        'sameAs',
        'schemaVersion',
        'sourceOrganization',
        'spatial',
        'spatialCoverage',
        'sponsor',
        'startTime',
        'subjectOf',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnail',
        'thumbnailUrl',
        'timeRequired',
        'transcript',
        'translator',
        'typicalAgeRange',
        'uploadDate',
        'url',
        'version',
        'video',
        'videoFrameSize',
        'videoQuality',
        'width',
        'workExample',
    ];
}
