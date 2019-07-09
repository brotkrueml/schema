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
     * @internal
     */
    public static function getClassNameWithoutNamespace(string $className): string
    {
        $classNameParts = \explode('\\', $className);

        return \end($classNameParts);
    }

    /**
     * Get the class name with namespace for a given type
     *
     * Returns null, if the class does not exist
     *
     * @param string $type Type
     * @return string|null
     * @internal
     */
    public static function getNamespacedClassNameForType(string $type): ?string
    {
        $className = 'Brotkrueml\\Schema\\Model\\Type\\' . $type;

        if (!\class_exists($className)) {
            return null;
        }

        return $className;
    }
}
