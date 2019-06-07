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
 * A datasheet or vendor specification of a product (in the sense of a prototypical description).
 *
 * schema.org version 3.6
 */
class ProductModel extends Product
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('isVariantOf', 'predecessorOf', 'successorOf');
    }
}
