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
 * A part of a successively published publication such as a periodical or publication volume, often numbered, usually containing a grouping of works such as articles.
 *
 * schema.org version 3.6
 */
class PublicationIssueViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('issueNumber', 'mixed', 'Identifies the issue of publication; for example, "iii" or "2".');
        $this->registerArgument('pageEnd', 'mixed', 'The page on which the work ends; for example "138" or "xvi".');
        $this->registerArgument('pageStart', 'mixed', 'The page on which the work starts; for example "135" or "xiii".');
        $this->registerArgument('pagination', 'mixed', 'Any description of pages that is not separated into pageStart and pageEnd; for example, "1-6, 9, 55" or "10-12, 46-49".');
    }
}
