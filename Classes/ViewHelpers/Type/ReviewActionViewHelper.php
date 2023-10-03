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
 * The act of producing a balanced opinion about the object for an audience. An agent reviews an object with participants resulting in a review.
 */
final class ReviewActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'ReviewAction';
}
