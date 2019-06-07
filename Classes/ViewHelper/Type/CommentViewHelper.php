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
 * A comment on an item - for example, a comment on a blog post. The comment\'s content is expressed via the text property, and its topic via about, properties shared with all CreativeWorks.
 *
 * schema.org version 3.6
 */
class CommentViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('downvoteCount', 'mixed', 'The number of downvotes this question, answer or comment has received from the community.');
        $this->registerArgument('parentItem', 'mixed', 'The parent of a question, answer or item in general.');
        $this->registerArgument('upvoteCount', 'mixed', 'The number of upvotes this question, answer or comment has received from the community.');
    }
}
