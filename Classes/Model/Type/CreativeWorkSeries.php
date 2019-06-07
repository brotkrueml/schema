<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A CreativeWorkSeries in schema.org is a group of related items, typically but not necessarily of the same kind. CreativeWorkSeries are usually organized into some order, often chronological. Unlike ItemList which is a general purpose data structure for lists of things, the emphasis with CreativeWorkSeries is on published materials (written e.g. books and periodicals, or media such as tv, radio and games).
 *
 * schema.org version 3.6
 */
class CreativeWorkSeries extends Series
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('about', 'accessMode', 'accessModeSufficient', 'accessibilityAPI', 'accessibilityControl', 'accessibilityFeature', 'accessibilityHazard', 'accessibilitySummary', 'accountablePerson', 'aggregateRating', 'alternativeHeadline', 'associatedMedia', 'audience', 'audio', 'author', 'award', 'character', 'citation', 'comment', 'commentCount', 'contentLocation', 'contentRating', 'contributor', 'copyrightHolder', 'copyrightYear', 'creator', 'dateCreated', 'dateModified', 'datePublished', 'discussionUrl', 'editor', 'educationalAlignment', 'educationalUse', 'encoding', 'encodingFormat', 'endDate', 'exampleOfWork', 'expires', 'funder', 'genre', 'hasPart', 'headline', 'inLanguage', 'interactionStatistic', 'interactivityType', 'isAccessibleForFree', 'isBasedOn', 'isFamilyFriendly', 'isPartOf', 'issn', 'keywords', 'learningResourceType', 'license', 'locationCreated', 'mainEntity', 'material', 'mentions', 'offers', 'position', 'producer', 'provider', 'publication', 'publisher', 'publishingPrinciples', 'recordedAt', 'releasedEvent', 'review', 'schemaVersion', 'sourceOrganization', 'spatial', 'spatialCoverage', 'sponsor', 'startDate', 'temporal', 'temporalCoverage', 'text', 'thumbnailUrl', 'timeRequired', 'translator', 'typicalAgeRange', 'version', 'video', 'workExample');
    }
}
