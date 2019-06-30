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
 * The act of generating a comment about a subject.
 */
class CommentAction extends AbstractType
{
    use TypeTrait\ActionTrait;
    use TypeTrait\CommentActionTrait;
    use TypeTrait\CommunicateActionTrait;
    use TypeTrait\ThingTrait;
}
