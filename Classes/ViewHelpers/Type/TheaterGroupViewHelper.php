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
 * A theater group or company, for example, the Royal Shakespeare Company or Druid Theatre.
 */
final class TheaterGroupViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'TheaterGroup';
}
