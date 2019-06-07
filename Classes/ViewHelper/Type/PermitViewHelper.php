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
 * A permit issued by an organization, e.g. a parking pass.
 *
 * schema.org version 3.6
 */
class PermitViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('issuedBy', 'mixed', 'The organization issuing the ticket or permit.');
        $this->registerArgument('issuedThrough', 'mixed', 'The service through with the permit was granted.');
        $this->registerArgument('permitAudience', 'mixed', 'The target audience for this permit.');
        $this->registerArgument('validFor', 'mixed', 'The duration of validity of a permit or similar thing.');
        $this->registerArgument('validFrom', 'mixed', 'The date when the item becomes valid.');
        $this->registerArgument('validIn', 'mixed', 'The geographic area where a permit or similar thing is valid.');
        $this->registerArgument('validUntil', 'mixed', 'The date when the item is no longer valid.');
    }
}
