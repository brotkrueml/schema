<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;

trait FixtureThingTraitA
{
    protected $name;
    protected $url;
}

trait FixtureThingTraitB
{
    protected $description;
    protected $image;
    protected $alternateName;
    protected $identifier;
}

class FixtureThing extends AbstractType
{
    use FixtureThingTraitA;
    use FixtureThingTraitB;
}
