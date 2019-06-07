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
 * A LegalService is a business that provides legally-oriented services, advice and representation, e.g. law firms.
 *
 * schema.org version 3.6
 */
class LegalService extends LocalBusiness
{
    public function __construct()
    {
        parent::__construct();
    }
}
