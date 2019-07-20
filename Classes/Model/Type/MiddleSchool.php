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
 * A middle school (typically for children aged around 11-14, although this varies somewhat).
 */
final class MiddleSchool extends AbstractType
{
    use TypeTrait\EducationalOrganizationTrait;
    use TypeTrait\OrganizationTrait;
    use TypeTrait\ThingTrait;
}
