<?php
declare(strict_types = 1);

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
 * An image of a visual machine-readable code such as a barcode or QR code.
 */
final class Barcode extends AbstractType
{
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\ImageObjectTrait;
    use TypeTrait\MediaObjectTrait;
    use TypeTrait\ThingTrait;
}
