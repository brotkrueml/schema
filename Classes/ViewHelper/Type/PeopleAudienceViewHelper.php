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
 * A set of characteristics belonging to people, e.g. who compose an item\'s target audience.
 *
 * schema.org version 3.6
 */
class PeopleAudienceViewHelper extends AudienceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('requiredGender', 'mixed', 'Audiences defined by a person\'s gender.');
        $this->registerArgument('requiredMaxAge', 'mixed', 'Audiences defined by a person\'s maximum age.');
        $this->registerArgument('requiredMinAge', 'mixed', 'Audiences defined by a person\'s minimum age.');
        $this->registerArgument('suggestedGender', 'mixed', 'The gender of the person or audience.');
        $this->registerArgument('suggestedMaxAge', 'mixed', 'Maximal age recommended for viewing content.');
        $this->registerArgument('suggestedMinAge', 'mixed', 'Minimal age recommended for viewing content.');
    }
}
