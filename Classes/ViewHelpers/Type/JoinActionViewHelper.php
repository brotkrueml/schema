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
 * An agent joins an event/group with participants/friends at a location.
 *
 * Related actions:
 * RegisterAction: Unlike RegisterAction, JoinAction refers to joining a group/team of people.
 * SubscribeAction: Unlike SubscribeAction, JoinAction does not imply that you'll be receiving updates.
 * FollowAction: Unlike FollowAction, JoinAction does not imply that you'll be polling for updates.
 */
final class JoinActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'JoinAction';
}
