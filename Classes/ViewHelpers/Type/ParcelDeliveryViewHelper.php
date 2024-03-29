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
 * The delivery of a parcel either via the postal service or a commercial service.
 */
final class ParcelDeliveryViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'ParcelDelivery';
}
