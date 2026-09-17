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
 * Represents an item or group of closely related items treated as a unit for the sake of evaluation in a MediaReview. Authorship etc. apply to the items rather than to the curation/grouping or reviewing party.
 */
final class MediaReviewItemViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'MediaReviewItem';
}
