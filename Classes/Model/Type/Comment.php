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
 * A comment on an item - for example, a comment on a blog post. The comment\&#039;s content is expressed via the text property, and its topic via about, properties shared with all CreativeWorks.
 */
final class Comment extends AbstractType
{
    use TypeTrait\CommentTrait;
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\ThingTrait;
}
