<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Schema\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

enum BusinessEntityType implements EnumerationInterface
{
    case Business;
    case Enduser;
    case PublicInstitution;
    case Reseller;

    public function canonical(): string
    {
        return 'http://purl.org/goodrelations/v1#' . $this->name;
    }
}
