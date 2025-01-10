<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Schema\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

enum GenderType implements EnumerationInterface
{
    case Androgyne;
    case Bigender;
    case Binary;
    case Cis;
    case DemiBoy;
    case DemiGirl;
    case Eunuch;
    case Female;
    case Genderless;
    case Intersex;
    case Male;
    case Multigender;
    case Neither;
    case Polygender;
    case Queer;
    case Transgender;

    public function canonical(): string
    {
        return match ($this) {
            self::DemiBoy => 'Demi-boy',
            self::DemiGirl => 'Demi-girl',
            self::Female, self::Male => 'https://schema.org/' . $this->name,
            default => $this->name,
        };
    }
}
