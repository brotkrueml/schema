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
 * An article, such as a news article or piece of investigative report. Newspapers and magazines have articles of many different types and this is intended to cover them all.
 *
 * schema.org version 3.6
 */
class ArticleViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('articleBody', 'mixed', 'The actual body of the article.');
        $this->registerArgument('articleSection', 'mixed', 'Articles may belong to one or more \'sections\' in a magazine or newspaper, such as Sports, Lifestyle, etc.');
        $this->registerArgument('pageEnd', 'mixed', 'The page on which the work ends; for example "138" or "xvi".');
        $this->registerArgument('pageStart', 'mixed', 'The page on which the work starts; for example "135" or "xiii".');
        $this->registerArgument('pagination', 'mixed', 'Any description of pages that is not separated into pageStart and pageEnd; for example, "1-6, 9, 55" or "10-12, 46-49".');
        $this->registerArgument('speakable', 'mixed', 'Indicates sections of a Web page that are particularly \'speakable\' in the sense of being highlighted as being especially appropriate for text-to-speech conversion. Other sections of a page may also be usefully spoken in particular circumstances; the \'speakable\' property serves to indicate the parts most likely to be generally useful for speech.');
        $this->registerArgument('wordCount', 'mixed', 'The number of words in the text of the Article.');
    }
}
