<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Helper;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
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
