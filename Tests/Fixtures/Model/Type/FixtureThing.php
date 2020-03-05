<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

class FixtureThing extends AbstractType
{
    protected $properties = [
        'alternateName' => null,
        'description' => null,
        'identifier' => null,
        'image' => null,
        'name' => null,
        'url' => null,
    ];
}
