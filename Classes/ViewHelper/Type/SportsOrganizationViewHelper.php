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
 * Represents the collection of all sports organizations, including sports teams, governing bodies, and sports associations.
 *
 * schema.org version 3.6
 */
class SportsOrganizationViewHelper extends OrganizationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('sport', 'mixed', 'A type of sport (e.g. Baseball).');
    }
}
