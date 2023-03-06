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
 * The act of registering to be a user of a service, product or web page.
 *
 * Related actions:
 * JoinAction: Unlike JoinAction, RegisterAction implies you are registering to be a user of a service, *not* a group/team of people.
 * FollowAction: Unlike FollowAction, RegisterAction doesn't imply that the agent is expecting to poll for updates from the object.
 * SubscribeAction: Unlike SubscribeAction, RegisterAction doesn't imply that the agent is expecting updates from the object.
 */
final class RegisterActionViewHelper extends AbstractTypeViewHelper
{
}
