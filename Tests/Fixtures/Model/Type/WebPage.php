<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

final class WebPage extends AbstractType
{
    protected $properties = [
        'expires' => null,
    ];
}
