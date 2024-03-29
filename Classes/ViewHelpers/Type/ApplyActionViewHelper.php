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
 * The act of registering to an organization/service without the guarantee to receive it.
 *
 * Related actions:
 * RegisterAction: Unlike RegisterAction, ApplyAction has no guarantees that the application will be accepted.
 */
final class ApplyActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'ApplyAction';
}
