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
 * A direction indicating a single action to do in the instructions for how to achieve a result.
 *
 * schema.org version 3.6
 */
class HowToDirection extends ListItem
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('about', 'accessMode', 'accessModeSufficient', 'accessibilityAPI', 'accessibilityControl', 'accessibilityFeature', 'accessibilityHazard', 'accessibilitySummary', 'accountablePerson', 'afterMedia', 'aggregateRating', 'alternativeHeadline', 'associatedMedia', 'audience', 'audio', 'author', 'award', 'beforeMedia', 'character', 'citation', 'comment', 'commentCount', 'contentLocation', 'contentRating', 'contributor', 'copyrightHolder', 'copyrightYear', 'creator', 'dateCreated', 'dateModified', 'datePublished', 'discussionUrl', 'duringMedia', 'editor', 'educationalAlignment', 'educationalUse', 'encoding', 'encodingFormat', 'exampleOfWork', 'expires', 'funder', 'genre', 'hasPart', 'headline', 'inLanguage', 'interactionStatistic', 'interactivityType', 'isAccessibleForFree', 'isBasedOn', 'isFamilyFriendly', 'isPartOf', 'keywords', 'learningResourceType', 'license', 'locationCreated', 'mainEntity', 'material', 'mentions', 'offers', 'performTime', 'prepTime', 'producer', 'provider', 'publication', 'publisher', 'publishingPrinciples', 'recordedAt', 'releasedEvent', 'review', 'schemaVersion', 'sourceOrganization', 'spatial', 'spatialCoverage', 'sponsor', 'supply', 'temporal', 'temporalCoverage', 'text', 'thumbnailUrl', 'timeRequired', 'tool', 'totalTime', 'translator', 'typicalAgeRange', 'version', 'video', 'workExample');
    }
}
