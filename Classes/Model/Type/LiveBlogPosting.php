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
 * A blog post intended to provide a rolling textual coverage of an ongoing event through continuous updates.
 */
class LiveBlogPosting extends AbstractType
{
    use TypeTrait\ArticleTrait;
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\LiveBlogPostingTrait;
    use TypeTrait\SocialMediaPostingTrait;
    use TypeTrait\ThingTrait;
}
