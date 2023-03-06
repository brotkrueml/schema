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
 * The act of gaining ownership of an object from an origin. Reciprocal of GiveAction.
 *
 * Related actions:
 * GiveAction: The reciprocal of TakeAction.
 * ReceiveAction: Unlike ReceiveAction, TakeAction implies that ownership has been transferred.
 */
final class TakeActionViewHelper extends AbstractTypeViewHelper
{
}
