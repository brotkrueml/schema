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
 * An instance of a Course which is distinct from other instances because it is offered at a different time or location or through different media or modes of study or to a specific section of students.
 *
 * schema.org version 3.6
 */
class CourseInstance extends Event
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('courseMode', 'instructor');
    }
}
