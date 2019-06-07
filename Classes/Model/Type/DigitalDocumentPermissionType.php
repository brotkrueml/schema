<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A type of permission which can be granted for accessing a digital document.
 *
 * schema.org version 3.6
 */
class DigitalDocumentPermissionType extends Enumeration
{
    public function __construct()
    {
        parent::__construct();
    }
}
