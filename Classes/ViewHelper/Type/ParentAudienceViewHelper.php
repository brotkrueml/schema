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
 * A set of characteristics describing parents, who can be interested in viewing some content.
 *
 * schema.org version 3.6
 */
class ParentAudienceViewHelper extends PeopleAudienceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('childMaxAge', 'mixed', 'Maximal age of the child.');
        $this->registerArgument('childMinAge', 'mixed', 'Minimal age of the child.');
    }
}
