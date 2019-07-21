<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Signal;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
final class PropertyRegistration
{
    private $propertiesForTypes = [];

    public function addPropertyForType(string $type, string $propertyName): self
    {
        if (!isset($this->propertiesForTypes[$type])) {
            $this->propertiesForTypes[$type] = [];
        }

        if (!\in_array($propertyName, $this->propertiesForTypes[$type])) {
            $this->propertiesForTypes[$type][] = $propertyName;
        }

        return $this;
    }

    /**
     * Do not use this method, it can change without notice!
     *
     * @param string $type
     * @return array
     *
     * @internal
     */
    public function getPropertiesForType(string $type): array
    {
        if (isset($this->propertiesForTypes[$type])) {
            return $this->propertiesForTypes[$type];
        }

        return [];
    }
}
