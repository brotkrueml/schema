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
 * A NewsArticle is an article whose content reports news, or provides background context and supporting materials for understanding the news.
 *
 * schema.org version 3.6
 */
class NewsArticle extends Article
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('dateline', 'printColumn', 'printEdition', 'printPage', 'printSection');
    }
}
