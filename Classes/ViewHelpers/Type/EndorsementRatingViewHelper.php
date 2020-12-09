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
 * An EndorsementRating is a rating that expresses some level of endorsement, for example inclusion in a "critic's pick" blog, a
 * "Like" or "+1" on a social network. It can be considered the result of an EndorseAction in which the object of the action is rated positively by
 * some agent. As is common elsewhere in schema.org, it is sometimes more useful to describe the results of such an action without explicitly describing the Action.
 *
 * An EndorsementRating may be part of a numeric scale or organized system, but this is not required: having an explicit type for indicating a positive,
 * endorsement rating is particularly useful in the absence of numeric scales as it helps consumers understand that the rating is broadly positive.
 */
final class EndorsementRatingViewHelper extends AbstractTypeViewHelper
{
}
