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
 * A specific question - e.g. from a user seeking answers online, or collected in a Frequently Asked Questions (FAQ) document.
 */
#[Type('Question')]
#[Manual(Publisher::Google, 'FAQ', 'https://developers.google.com/search/docs/appearance/structured-data/faqpage')]
#[Manual(Publisher::Google, 'Q&amp;A', 'https://developers.google.com/search/docs/appearance/structured-data/qapage')]
#[Manual(Publisher::Google, 'Education Q&amp;A', 'https://developers.google.com/search/docs/appearance/structured-data/education-qa')]
final class Question extends AbstractType
{
    protected static array $propertyNames = [
        'about',
        'acceptedAnswer',
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
        'answerCount',
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
        'countryOfOrigin',
        'creator',
        'dateCreated',
        'dateModified',
        'datePublished',
        'description',
        'disambiguatingDescription',
        'discussionUrl',
        'downvoteCount',
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
        'parentItem',
        'position',
        'potentialAction',
        'producer',
        'publication',
        'publisher',
        'publishingPrinciples',
        'recordedAt',
        'releasedEvent',
        'review',
        'sameAs',
        'schemaVersion',
        'sharedContent',
        'sourceOrganization',
        'spatial',
        'spatialCoverage',
        'sponsor',
        'subjectOf',
        'suggestedAnswer',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnail',
        'thumbnailUrl',
        'timeRequired',
        'translator',
        'typicalAgeRange',
        'upvoteCount',
        'url',
        'version',
        'video',
        'wordCount',
        'workExample',
    ];
}
