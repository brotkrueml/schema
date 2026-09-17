<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A MediaReview is a more specialized form of Review dedicated to the evaluation of media content online, typically in the context of fact-checking and misinformation.
 * For more general reviews of media in the broader sense, use UserReview, CriticReview or other Review types. This definition is
 * a work in progress. While the MediaManipulationRatingEnumeration list reflects significant community review amongst fact-checkers and others working
 * to combat misinformation, the specific structures for representing media objects, their versions and publication context, are still evolving. Similarly, best practices for the relationship between MediaReview and ClaimReview markup have not yet been finalized.
 */
final class MediaReviewViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'MediaReview';
}
