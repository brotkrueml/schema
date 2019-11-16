<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A fact-checking review of claims made (or reported) in some creative work (referenced via itemReviewed).
 */
final class ClaimReview extends AbstractType
{
    use TypeTrait\ClaimReviewTrait;
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\ReviewTrait;
    use TypeTrait\ThingTrait;
}
