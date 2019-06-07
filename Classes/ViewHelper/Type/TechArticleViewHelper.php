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
 * A technical article - Example: How-to (task) topics, step-by-step, procedural troubleshooting, specifications, etc.
 *
 * schema.org version 3.6
 */
class TechArticleViewHelper extends ArticleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('dependencies', 'mixed', 'Prerequisites needed to fulfill steps in article.');
        $this->registerArgument('proficiencyLevel', 'mixed', 'Proficiency needed for this content; expected values: \'Beginner\', \'Expert\'.');
    }
}
