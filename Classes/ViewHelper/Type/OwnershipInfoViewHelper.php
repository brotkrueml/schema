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
 * A structured value providing information about when a certain organization or person owned a certain product.
 *
 * schema.org version 3.6
 */
class OwnershipInfoViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('acquiredFrom', 'mixed', 'The organization or person from which the product was acquired.');
        $this->registerArgument('ownedFrom', 'mixed', 'The date and time of obtaining the product.');
        $this->registerArgument('ownedThrough', 'mixed', 'The date and time of giving up ownership on the product.');
        $this->registerArgument('typeOfGood', 'mixed', 'The product that this structured value is referring to.');
    }
}
