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
 * A range of services that will be provided to a customer free of charge in case of a defect or malfunction of a product.
 *
 * Commonly used values:
 * http://purl.org/goodrelations/v1#Labor-BringIn
 * http://purl.org/goodrelations/v1#PartsAndLabor-BringIn
 * http://purl.org/goodrelations/v1#PartsAndLabor-PickUp
 * @deprecated This type represents an enumeration, use the enum with the {f:constant()} ViewHelper instead (available since Fluid 2.12).
 */
final class WarrantyScopeViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'WarrantyScope';
}
