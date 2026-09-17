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
 * An intangible type to be applied to any archive content, carrying with it a set of properties required to describe archival items and collections.
 */
final class ArchiveComponentViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'ArchiveComponent';
}
