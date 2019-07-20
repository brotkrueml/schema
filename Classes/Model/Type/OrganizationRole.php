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
 * A subclass of Role used to describe roles within organizations.
 */
final class OrganizationRole extends AbstractType
{
    use TypeTrait\OrganizationRoleTrait;
    use TypeTrait\RoleTrait;
    use TypeTrait\ThingTrait;
}
