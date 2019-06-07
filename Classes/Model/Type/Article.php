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
 * An article, such as a news article or piece of investigative report. Newspapers and magazines have articles of many different types and this is intended to cover them all.
 *
 * schema.org version 3.6
 */
class Article extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('articleBody', 'articleSection', 'pageEnd', 'pageStart', 'pagination', 'speakable', 'wordCount');
    }
}
