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
 * The business function specifies the type of activity or access (i.e., the bundle of rights) offered by the organization or business person through the offer. Typical are sell, rental or lease, maintenance or repair, manufacture / produce, recycle / dispose, engineering / construction, or installation. Proprietary specifications of access rights are also instances of this class.
 *
 * Commonly used values:
 * http://purl.org/goodrelations/v1#ConstructionInstallation
 * http://purl.org/goodrelations/v1#Dispose
 * http://purl.org/goodrelations/v1#LeaseOut
 * http://purl.org/goodrelations/v1#Maintain
 * http://purl.org/goodrelations/v1#ProvideService
 * http://purl.org/goodrelations/v1#Repair
 * http://purl.org/goodrelations/v1#Sell
 * http://purl.org/goodrelations/v1#Buy
 * @deprecated This type represents an enumeration, use the enum with the {f:constant()} ViewHelper instead (available since Fluid 2.12).
 */
final class BusinessFunctionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'BusinessFunction';
}
