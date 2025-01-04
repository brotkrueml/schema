<?php

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

enum GenericEnumeration implements EnumerationInterface
{
    case Member1;
    case Member2;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
