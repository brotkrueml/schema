<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Model;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;

#[Type('GenericStub')]
class GenericStub implements NodeIdentifierInterface, TypeInterface
{
    public function __construct(
        private readonly ?string $id = null,
        private array $properties = [],
        private readonly string $type = 'GenericStub',
    ) {}

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId($id): static
    {
        throw new \Exception('Should not be called!');
    }

    public function hasProperty(string $propertyName): bool
    {
        return true;
    }

    public function getProperty(string $propertyName): mixed
    {
        return $this->properties[$propertyName];
    }

    public function setProperty(string $propertyName, $propertyValue): static
    {
        throw new \Exception('Should not be called!');
    }

    public function addProperty(string $propertyName, $propertyValue): static
    {
        if ($this->properties[$propertyName] === null) {
            $this->properties[$propertyName] = $propertyValue;
        }

        return $this;
    }

    public function setProperties(array $properties): static
    {
        throw new \Exception('Should not be called!');
    }

    public function clearProperty(string $propertyName): static
    {
        $this->properties[$propertyName] = null;

        return $this;
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
