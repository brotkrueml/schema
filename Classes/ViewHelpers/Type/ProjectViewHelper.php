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
 * An enterprise (potentially individual but typically collaborative), planned to achieve a particular aim.
 * Use properties from Organization, subOrganization/parentOrganization to indicate project sub-structures.
 */
final class ProjectViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Project';
}
