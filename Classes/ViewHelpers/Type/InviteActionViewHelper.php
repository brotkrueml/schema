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
 * The act of asking someone to attend an event. Reciprocal of RsvpAction.
 */
final class InviteActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'InviteAction';
}
