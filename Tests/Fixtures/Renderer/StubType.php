<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Renderer;

use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;

class StubType implements NodeIdentifierInterface, TypeInterface
{
    private ?string $id;
    private array $properties;
    private string $type;

    public function __construct(?string $id = null, array $properties = [], string $type = 'StubType')
    {
        $this->id = $id;
        $this->properties = $properties;
        $this->type = $type;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
    }

    public function hasProperty(string $propertyName): bool
    {
        return true;
    }

    public function getProperty(string $propertyName)
    {
        return $this->properties[$propertyName];
    }

    public function setProperty(string $propertyName, $propertyValue)
    {
    }

    public function addProperty(string $propertyName, $propertyValue)
    {
    }

    public function setProperties(array $properties)
    {
    }

    public function clearProperty(string $propertyName)
    {
    }

    public function getPropertyNames(): array
    {
        return \array_keys($this->properties);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
