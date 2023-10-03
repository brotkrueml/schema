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
 * A supply consumed when performing the instructions for how to achieve a result.
 */
final class HowToSupplyViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'HowToSupply';
}
