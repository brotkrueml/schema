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
 * The act of producing a visual/graphical representation of an object, typically with a pen/pencil and paper as instruments.
 */
final class DrawActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'DrawAction';
}
