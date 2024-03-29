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
 * A college, university, or other third-level educational institution.
 */
final class CollegeOrUniversityViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'CollegeOrUniversity';
}
