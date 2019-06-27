<?php

namespace Brotkrueml\Schema\Utility;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class Utility
{
    /**
     * Get the class name without the namespace
     *
     * @param string $className Class name with namespace
     * @return string
     */
    public static function getClassNameWithoutNamespace(string $className): string
    {
        $classNameParts = \explode('\\', $className);

        return \end($classNameParts);
    }
}
