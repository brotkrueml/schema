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
 * Organization: Sports team.
 *
 * schema.org version 3.6
 */
class SportsTeamViewHelper extends SportsOrganizationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('athlete', 'mixed', 'A person that acts as performing member of a sports team; a player as opposed to a coach.');
        $this->registerArgument('coach', 'mixed', 'A person that acts in a coaching role for a sports team.');
    }
}
