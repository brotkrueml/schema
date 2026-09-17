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
 * The ReportageNewsArticle type is a subtype of NewsArticle representing
 * news articles which are the result of journalistic news reporting conventions.
 *
 * In practice many news publishers produce a wide variety of article types, many of which might be considered a NewsArticle but not a ReportageNewsArticle. For example, opinion pieces, reviews, analysis, sponsored or satirical articles, or articles that combine several of these elements.
 *
 * The ReportageNewsArticle type is based on a stricter ideal for "news" as a work of journalism, with articles based on factual information either observed or verified by the author, or reported and verified from knowledgeable sources.  This often includes perspectives from multiple viewpoints on a particular issue (distinguishing news reports from public relations or propaganda).  News reports in the ReportageNewsArticle sense de-emphasize the opinion of the author, with commentary and value judgements typically expressed elsewhere.
 *
 * A ReportageNewsArticle which goes deeper into analysis can also be marked with an additional type of AnalysisNewsArticle.
 */
#[Type('ReportageNewsArticle')]
final class ReportageNewsArticle extends AbstractType
{
    protected static array $propertyNames = [
        'about',
        'abstract',
        'accessMode',
        'accessModeSufficient',
        'accessibilityAPI',
        'accessibilityControl',
        'accessibilityFeature',
        'accessibilityHazard',
        'accessibilitySummary',
        'accountablePerson',
        'acquireLicensePage',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'alternativeHeadline',
        'archivedAt',
        'articleBody',
        'articleSection',
        'assesses',
        'associatedMedia',
        'audience',
        'audio',
        'author',
        'award',
        'backstory',
        'character',
        'citation',
        'comment',
        'commentCount',
        'conditionsOfAccess',
        'contentLocation',
        'contentRating',
        'contentReferenceTime',
        'contributor',
        'copyrightHolder',
        'copyrightNotice',
        'copyrightYear',
        'correction',
        'countryOfOrigin',
        'creator',
        'creditText',
        'dateCreated',
        'dateModified',
        'datePublished',
        'dateline',
        'description',
        'digitalSourceType',
        'disambiguatingDescription',
        'discussionUrl',
        'editEIDR',
        'editor',
        'educationalAlignment',
        'educationalUse',
        'encoding',
        'encodingFormat',
        'exampleOfWork',
        'expires',
        'funder',
        'funding',
        'genre',
        'hasPart',
        'headline',
        'identifier',
        'image',
        'inLanguage',
        'interactionStatistic',
        'interactivityType',
        'interpretedAsClaim',
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
        'maintainer',
        'material',
        'materialExtent',
        'mentions',
        'name',
        'offers',
        'owner',
        'pageEnd',
        'pageStart',
        'pagination',
        'pattern',
        'position',
        'potentialAction',
        'printColumn',
        'printEdition',
        'printPage',
        'printSection',
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
        'sdDatePublished',
        'sdLicense',
        'sdPublisher',
        'size',
        'sourceOrganization',
        'spatial',
        'spatialCoverage',
        'speakable',
        'sponsor',
        'subjectOf',
        'teaches',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnail',
        'thumbnailUrl',
        'timeRequired',
        'translator',
        'typicalAgeRange',
        'url',
        'usageInfo',
        'version',
        'video',
        'wordCount',
        'workExample',
    ];
}
