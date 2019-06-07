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
 * An image of a visual machine-readable code such as a barcode or QR code.
 *
 * schema.org version 3.6
 */
class Barcode extends ImageObject
{
    public function __construct()
    {
        parent::__construct();
    }
}
