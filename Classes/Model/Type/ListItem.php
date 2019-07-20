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
 * An list item, e.g. a step in a checklist or how-to description.
 */
final class ListItem extends AbstractType
{
    use TypeTrait\ListItemTrait;
    use TypeTrait\ThingTrait;
}
