<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

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
