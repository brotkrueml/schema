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
 * A NewsArticle is an article whose content reports news, or provides background context and supporting materials for understanding the news.
 *
 * schema.org version 3.6
 */
class NewsArticleViewHelper extends ArticleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('dateline', 'mixed', 'A dateline is a brief piece of text included in news articles that describes where and when the story was written or filed though the date is often omitted. Sometimes only a placename is provided.');
        $this->registerArgument('printColumn', 'mixed', 'The number of the column in which the NewsArticle appears in the print edition.');
        $this->registerArgument('printEdition', 'mixed', 'The edition of the print product in which the NewsArticle appears.');
        $this->registerArgument('printPage', 'mixed', 'If this NewsArticle appears in print, this field indicates the name of the page on which the article is found. Please note that this field is intended for the exact page name (e.g. A5, B18).');
        $this->registerArgument('printSection', 'mixed', 'If this NewsArticle appears in print, this field indicates the print section in which the article appeared.');
    }
}
