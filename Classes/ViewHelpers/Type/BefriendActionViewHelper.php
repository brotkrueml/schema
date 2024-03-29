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
 * The act of forming a personal connection with someone (object) mutually/bidirectionally/symmetrically.
 *
 * Related actions:
 * FollowAction: Unlike FollowAction, BefriendAction implies that the connection is reciprocal.
 */
final class BefriendActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'BefriendAction';
}
