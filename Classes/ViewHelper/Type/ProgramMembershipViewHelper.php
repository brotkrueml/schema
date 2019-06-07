<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

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
class ProgramMembershipViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('hostingOrganization', 'mixed', 'The organization (airline, travelers\' club, etc.) the membership is made with.');
        $this->registerArgument('member', 'mixed', 'A member of an Organization or a ProgramMembership. Organizations can be members of organizations; ProgramMembership is typically for individuals.');
        $this->registerArgument('membershipNumber', 'mixed', 'A unique identifier for the membership.');
        $this->registerArgument('programName', 'mixed', 'The program providing the membership.');
    }
}
