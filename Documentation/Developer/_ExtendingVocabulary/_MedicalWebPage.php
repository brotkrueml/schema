<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Schema\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;

#[Type('MedicalWebPage')]
final class MedicalWebPage extends AbstractType implements WebPageTypeInterface
{
    protected static array $propertyNames = [
        // ... the properties ...
    ];
}
