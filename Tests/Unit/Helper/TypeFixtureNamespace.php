<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Helper;

use Brotkrueml\Schema\Tests\Fixtures\Paths;
use Brotkrueml\Schema\Utility\Utility;

trait TypeFixtureNamespace
{
    /** @var string */
    private static $originalNamespace;

    public static function setTypeNamespaceToFixtureNamespace(): void
    {
        static::$originalNamespace = Utility::setNamespaceForTypes(Paths::TYPE_PATH);
    }

    public static function restoreOriginalTypeNamespace(): void
    {
        Utility::setNamespaceForTypes(static::$originalNamespace);
    }
}
