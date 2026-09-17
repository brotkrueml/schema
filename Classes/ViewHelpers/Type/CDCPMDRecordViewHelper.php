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
 * A CDCPMDRecord is a data structure representing a record in a CDC tabular data format
 * used for hospital data reporting. See [documentation](/docs/cdc-covid.html) for details, and the linked CDC materials for authoritative
 * definitions used as the source here.
 */
final class CDCPMDRecordViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'CDCPMDRecord';
}
