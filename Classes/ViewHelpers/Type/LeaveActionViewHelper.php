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
 * An agent leaves an event / group with participants/friends at a location.

Related actions:

 * JoinAction: The antonym of LeaveAction.
 * UnRegisterAction: Unlike UnRegisterAction, LeaveAction implies leaving a group/team of people rather than a service.
 */
final class LeaveActionViewHelper extends AbstractTypeViewHelper
{
}
