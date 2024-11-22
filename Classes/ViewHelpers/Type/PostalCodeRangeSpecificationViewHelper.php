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
 * Indicates a range of postal codes, usually defined as the set of valid codes between postalCodeBegin and postalCodeEnd, inclusively.
 */
final class PostalCodeRangeSpecificationViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'PostalCodeRangeSpecification';
}
