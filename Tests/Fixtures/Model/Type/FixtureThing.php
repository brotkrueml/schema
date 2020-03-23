<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

class FixtureThing extends AbstractType
{
    protected static $propertyNames = [
        'alternateName',
        'description',
        'identifier',
        'image',
        'isAccessibleForFree',
        'name',
        'url',
    ];
}
