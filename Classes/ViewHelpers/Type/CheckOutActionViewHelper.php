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
 * The act of an agent communicating (service provider, social media, etc) their departure of a previously reserved service (e.g. flight check-in) or place (e.g. hotel).
 *
 * Related actions:
 * CheckInAction: The antonym of CheckOutAction.
 * DepartAction: Unlike DepartAction, CheckOutAction implies that the agent is informing/confirming the end of a previously reserved service.
 * CancelAction: Unlike CancelAction, CheckOutAction implies that the agent is informing/confirming the end of a previously reserved service.
 */
final class CheckOutActionViewHelper extends AbstractTypeViewHelper
{
}
