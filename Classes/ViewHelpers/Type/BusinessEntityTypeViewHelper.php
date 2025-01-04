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
 * A business entity type is a conceptual entity representing the legal form, the size, the main line of business, the position in the value chain, or any combination thereof, of an organization or business person.
 *
 * Commonly used values:
 * http://purl.org/goodrelations/v1#Business
 * http://purl.org/goodrelations/v1#Enduser
 * http://purl.org/goodrelations/v1#PublicInstitution
 * http://purl.org/goodrelations/v1#Reseller
 * @deprecated This type represents an enumeration, use the enum with the {f:constant()} ViewHelper instead (available since Fluid 2.12).
 */
final class BusinessEntityTypeViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'BusinessEntityType';
}
