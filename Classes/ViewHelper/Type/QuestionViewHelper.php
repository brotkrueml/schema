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
 * A specific question - e.g. from a user seeking answers online, or collected in a Frequently Asked Questions (FAQ) document.
 *
 * schema.org version 3.6
 */
class QuestionViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('acceptedAnswer', 'mixed', 'The answer(s) that has been accepted as best, typically on a Question/Answer site. Sites vary in their selection mechanisms, e.g. drawing on community opinion and/or the view of the Question author.');
        $this->registerArgument('answerCount', 'mixed', 'The number of answers this question has received.');
        $this->registerArgument('downvoteCount', 'mixed', 'The number of downvotes this question, answer or comment has received from the community.');
        $this->registerArgument('suggestedAnswer', 'mixed', 'An answer (possibly one of several, possibly incorrect) to a Question, e.g. on a Question/Answer site.');
        $this->registerArgument('upvoteCount', 'mixed', 'The number of upvotes this question, answer or comment has received from the community.');
    }
}
