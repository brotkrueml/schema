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
 * An instance of a Course which is distinct from other instances because it is offered at a different time or location or through different media or modes of study or to a specific section of students.
 *
 * schema.org version 3.6
 */
class CourseInstanceViewHelper extends EventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('courseMode', 'mixed', 'The medium or means of delivery of the course instance or the mode of study, either as a text label (e.g. "online", "onsite" or "blended"; "synchronous" or "asynchronous"; "full-time" or "part-time") or as a URL reference to a term from a controlled vocabulary (e.g. https://ceds.ed.gov/element/001311#Asynchronous ).');
        $this->registerArgument('instructor', 'mixed', 'A person assigned to instruct or provide instructional assistance for the CourseInstance.');
    }
}
