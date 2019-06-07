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
 * A technical article - Example: How-to (task) topics, step-by-step, procedural troubleshooting, specifications, etc.
 *
 * schema.org version 3.6
 */
class TechArticle extends Article
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('dependencies', 'proficiencyLevel');
    }
}
