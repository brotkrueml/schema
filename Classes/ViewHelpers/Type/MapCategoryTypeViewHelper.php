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
 * An enumeration of several kinds of Map.
 * @deprecated This type represents an enumeration, use the enum with the {f:constant()} ViewHelper instead (available since Fluid 2.12).
 */
final class MapCategoryTypeViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'MapCategoryType';
}
