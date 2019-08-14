<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

class FixtureImage extends AbstractType
{
    protected $name;
    protected $description;
    protected $image;
}
