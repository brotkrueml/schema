<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A musical group, such as a band, an orchestra, or a choir. Can also be a solo musician.
 */
final class MusicGroup extends AbstractType
{
    use TypeTrait\MusicGroupTrait;
    use TypeTrait\OrganizationTrait;
    use TypeTrait\ThingTrait;
}
