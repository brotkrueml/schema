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
 * A step in the instructions for how to achieve a result. It is an ordered list with HowToDirection and/or HowToTip items.
 *
 * schema.org version 3.6
 */
class HowToStep extends ListItem
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('about', 'accessMode', 'accessModeSufficient', 'accessibilityAPI', 'accessibilityControl', 'accessibilityFeature', 'accessibilityHazard', 'accessibilitySummary', 'accountablePerson', 'aggregateRating', 'alternativeHeadline', 'associatedMedia', 'audience', 'audio', 'author', 'award', 'character', 'citation', 'comment', 'commentCount', 'contentLocation', 'contentRating', 'contributor', 'copyrightHolder', 'copyrightYear', 'creator', 'dateCreated', 'dateModified', 'datePublished', 'discussionUrl', 'editor', 'educationalAlignment', 'educationalUse', 'encoding', 'encodingFormat', 'exampleOfWork', 'expires', 'funder', 'genre', 'hasPart', 'headline', 'inLanguage', 'interactionStatistic', 'interactivityType', 'isAccessibleForFree', 'isBasedOn', 'isFamilyFriendly', 'isPartOf', 'itemListElement', 'itemListOrder', 'keywords', 'learningResourceType', 'license', 'locationCreated', 'mainEntity', 'material', 'mentions', 'numberOfItems', 'offers', 'producer', 'provider', 'publication', 'publisher', 'publishingPrinciples', 'recordedAt', 'releasedEvent', 'review', 'schemaVersion', 'sourceOrganization', 'spatial', 'spatialCoverage', 'sponsor', 'temporal', 'temporalCoverage', 'text', 'thumbnailUrl', 'timeRequired', 'translator', 'typicalAgeRange', 'version', 'video', 'workExample');
    }
}
