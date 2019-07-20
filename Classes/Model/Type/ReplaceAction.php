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
 * The act of editing a recipient by replacing an old object with a new object.
 */
final class ReplaceAction extends AbstractType
{
    use TypeTrait\ActionTrait;
    use TypeTrait\ReplaceActionTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\UpdateActionTrait;
}
