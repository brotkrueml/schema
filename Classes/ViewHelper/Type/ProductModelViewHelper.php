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
 * A datasheet or vendor specification of a product (in the sense of a prototypical description).
 *
 * schema.org version 3.6
 */
class ProductModelViewHelper extends ProductViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('isVariantOf', 'mixed', 'A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.');
        $this->registerArgument('predecessorOf', 'mixed', 'A pointer from a previous, often discontinued variant of the product to its newer variant.');
        $this->registerArgument('successorOf', 'mixed', 'A pointer from a newer variant of a product  to its previous, often discontinued predecessor.');
    }
}
