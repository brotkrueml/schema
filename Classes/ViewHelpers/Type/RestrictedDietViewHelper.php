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
 * A diet restricted to certain foods or preparations for cultural, religious, health or lifestyle reasons.
 */
final class RestrictedDietViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'RestrictedDiet';
}
