<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A NewsArticle is an article whose content reports news, or provides background context and supporting materials for understanding the news.
 */
final class NewsArticle extends AbstractType
{
    use TypeTrait\ArticleTrait;
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\NewsArticleTrait;
    use TypeTrait\ThingTrait;
}
