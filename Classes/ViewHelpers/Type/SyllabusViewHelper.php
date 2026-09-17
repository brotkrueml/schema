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
 * A syllabus that describes the material covered in a course, often with several such sections per Course so that a distinct timeRequired can be provided for that section of the Course.
 */
final class SyllabusViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Syllabus';
}
