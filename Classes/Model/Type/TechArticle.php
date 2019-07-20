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
 * A technical article - Example: How-to (task) topics, step-by-step, procedural troubleshooting, specifications, etc.
 */
final class TechArticle extends AbstractType
{
    use TypeTrait\ArticleTrait;
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\TechArticleTrait;
    use TypeTrait\ThingTrait;
}
