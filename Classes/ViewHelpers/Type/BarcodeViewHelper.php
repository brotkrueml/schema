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
 * An image of a visual machine-readable code such as a barcode or QR code.
 */
final class BarcodeViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Barcode';
}
