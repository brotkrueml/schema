<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A fact-checking review of claims made (or reported) in some creative work (referenced via itemReviewed).
 *
 * schema.org version 3.6
 */
class ClaimReviewViewHelper extends ReviewViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('claimReviewed', 'mixed', 'A short summary of the specific claims reviewed in a ClaimReview.');
    }
}
