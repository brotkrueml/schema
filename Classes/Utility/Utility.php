<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Utility;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

final class Utility
{
    private static $typeNamespace = 'Brotkrueml\\Schema\\Model\\Type';

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
        $classNameWithoutNamespace = \end($classNameParts);

        return $classNameWithoutNamespace === false ? '' : $classNameWithoutNamespace;
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
        $className = static::$typeNamespace . '\\' . $type;

        if (!\class_exists($className)) {
            return null;
        }

        return $className;
    }

    /**
     * Only for testing purposes!
     *
     * @param string $namespace
     * @return string
     *
     * @internal
     */
    public static function setNamespaceForTypes(string $namespace): string
    {
        $originalNamespace = static::$typeNamespace;
        static::$typeNamespace = $namespace;

        return $originalNamespace;
    }
}
