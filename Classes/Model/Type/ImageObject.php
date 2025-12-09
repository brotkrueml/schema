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
 * An image file.
 */
#[Type('ImageObject')]
#[Manual(Publisher::Google, 'Image metadata', 'https://developers.google.com/search/docs/appearance/structured-data/image-license-metadata')]
final class ImageObject extends AbstractType
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
        'exifData',
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
        'name',
        'offers',
        'owner',
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
        'representativeOfPage',
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
        'translator',
        'typicalAgeRange',
        'uploadDate',
        'url',
        'version',
        'video',
        'width',
        'wordCount',
        'workExample',
    ];
}
