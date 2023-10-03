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
 * A video game is an electronic game that involves human interaction with a user interface to generate visual feedback on a video device.
 */
final class VideoGameViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'VideoGame';
}
