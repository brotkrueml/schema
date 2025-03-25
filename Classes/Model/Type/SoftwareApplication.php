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
 * A software application.
 */
#[Type('SoftwareApplication')]
#[Manual(Publisher::Google, 'https://developers.google.com/search/docs/appearance/structured-data/software-app')]
#[Manual(Publisher::Yandex, 'https://yandex.com/support/webmaster/supported-schemas/software.html')]
final class SoftwareApplication extends AbstractType
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
        'applicationCategory',
        'applicationSubCategory',
        'applicationSuite',
        'associatedMedia',
        'audience',
        'audio',
        'author',
        'availableOnDevice',
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
        'countriesNotSupported',
        'countriesSupported',
        'countryOfOrigin',
        'creator',
        'dateCreated',
        'dateModified',
        'datePublished',
        'description',
        'disambiguatingDescription',
        'discussionUrl',
        'downloadUrl',
        'editor',
        'educationalAlignment',
        'educationalUse',
        'encoding',
        'encodingFormat',
        'exampleOfWork',
        'expires',
        'featureList',
        'fileSize',
        'funder',
        'genre',
        'hasPart',
        'headline',
        'identifier',
        'image',
        'inLanguage',
        'installUrl',
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
        'memoryRequirements',
        'mentions',
        'name',
        'offers',
        'operatingSystem',
        'permissions',
        'position',
        'potentialAction',
        'processorRequirements',
        'producer',
        'publication',
        'publisher',
        'publishingPrinciples',
        'recordedAt',
        'releaseNotes',
        'releasedEvent',
        'review',
        'sameAs',
        'schemaVersion',
        'screenshot',
        'softwareAddOn',
        'softwareHelp',
        'softwareRequirements',
        'softwareVersion',
        'sourceOrganization',
        'spatial',
        'spatialCoverage',
        'sponsor',
        'storageRequirements',
        'subjectOf',
        'supportingData',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnail',
        'thumbnailUrl',
        'timeRequired',
        'translator',
        'typicalAgeRange',
        'url',
        'version',
        'video',
        'wordCount',
        'workExample',
    ];
}
