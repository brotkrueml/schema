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
 * Properties that take Distances as values are of the form '<Number> <Length unit of measure>'. E.g., '7 ft'.
 */
final class DistanceViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Distance';
}
