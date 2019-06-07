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
 * A blog post intended to provide a rolling textual coverage of an ongoing event through continuous updates.
 *
 * schema.org version 3.6
 */
class LiveBlogPostingViewHelper extends BlogPostingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('coverageEndTime', 'mixed', 'The time when the live blog will stop covering the Event. Note that coverage may continue after the Event concludes.');
        $this->registerArgument('coverageStartTime', 'mixed', 'The time when the live blog will begin covering the Event. Note that coverage may begin before the Event\'s start time. The LiveBlogPosting may also be created before coverage begins.');
        $this->registerArgument('liveBlogUpdate', 'mixed', 'An update to the LiveBlog.');
    }
}
