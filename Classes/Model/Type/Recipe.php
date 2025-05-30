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
 * A recipe. For dietary restrictions covered by the recipe, a few common restrictions are enumerated via suitableForDiet. The keywords property can also be used to add more detail.
 */
#[Type('Recipe')]
#[Manual(Publisher::Google, 'Recipe', 'https://developers.google.com/search/docs/appearance/structured-data/recipe')]
#[Manual(Publisher::Yandex, 'Recipes', 'https://yandex.com/support/webmaster/supported-schemas/recipe.html')]
final class Recipe extends AbstractType
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
        'citation',
        'comment',
        'commentCount',
        'contentLocation',
        'contentRating',
        'contributor',
        'cookTime',
        'cookingMethod',
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
        'estimatedCost',
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
        'nutrition',
        'offers',
        'performTime',
        'position',
        'potentialAction',
        'prepTime',
        'producer',
        'publication',
        'publisher',
        'publishingPrinciples',
        'recipeCategory',
        'recipeCuisine',
        'recipeIngredient',
        'recipeInstructions',
        'recipeYield',
        'recordedAt',
        'releasedEvent',
        'review',
        'sameAs',
        'schemaVersion',
        'sourceOrganization',
        'spatial',
        'spatialCoverage',
        'sponsor',
        'step',
        'subjectOf',
        'suitableForDiet',
        'supply',
        'temporal',
        'temporalCoverage',
        'text',
        'thumbnail',
        'thumbnailUrl',
        'timeRequired',
        'tool',
        'totalTime',
        'translator',
        'typicalAgeRange',
        'url',
        'version',
        'video',
        'wordCount',
        'workExample',
        'yield',
    ];
}
