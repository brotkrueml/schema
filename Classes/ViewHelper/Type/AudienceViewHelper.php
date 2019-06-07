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
 * Intended audience for an item, i.e. the group for whom the item was created.
 *
 * schema.org version 3.6
 */
class AudienceViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('audienceType', 'mixed', 'The target group associated with a given audience (e.g. veterans, car owners, musicians, etc.).');
        $this->registerArgument('geographicArea', 'mixed', 'The geographic area associated with the audience.');
    }
}
