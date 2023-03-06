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
 * The act of an agent communicating (service provider, social media, etc) their arrival by registering/confirming for a previously reserved service (e.g. flight check-in) or at a place (e.g. hotel), possibly resulting in a result (boarding pass, etc).
 *
 * Related actions:
 * CheckOutAction: The antonym of CheckInAction.
 * ArriveAction: Unlike ArriveAction, CheckInAction implies that the agent is informing/confirming the start of a previously reserved service.
 * ConfirmAction: Unlike ConfirmAction, CheckInAction implies that the agent is informing/confirming the *start* of a previously reserved service rather than its validity/existence.
 */
final class CheckInActionViewHelper extends AbstractTypeViewHelper
{
}
