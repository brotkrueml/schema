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
 * An organization with archival holdings. An organization which keeps and preserves archival material and typically makes it accessible to the public.
 */
final class ArchiveOrganizationViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'ArchiveOrganization';
}
