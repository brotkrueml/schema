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
 * A permit issued by an organization, e.g. a parking pass.
 *
 * schema.org version 3.6
 */
class Permit extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('issuedBy', 'issuedThrough', 'permitAudience', 'validFor', 'validFrom', 'validIn', 'validUntil');
    }
}
