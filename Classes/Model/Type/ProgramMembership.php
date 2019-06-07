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
 * Used to describe membership in a loyalty programs (e.g. "StarAliance"), traveler clubs (e.g. "AAA"), purchase clubs ("Safeway Club"), etc.
 *
 * schema.org version 3.6
 */
class ProgramMembership extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('hostingOrganization', 'member', 'membershipNumber', 'programName');
    }
}
