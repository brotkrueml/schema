<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Type;

use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\Manual\Manual;
use Brotkrueml\Schema\Manual\Publisher;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * @internal
 */
final class TypeProvider implements SingletonInterface
{
    /**
     * @var array<string, class-string>
     */
    private array $types = [];

    /**
     * @var list<string>
     */
    private array $webPageTypes = [];

    /**
     * @var array<string, list<Manual>>
     */
    private array $manuals = [];

    /**
     * @param non-empty-string $type
     * @param class-string $className
     */
    public function addType(string $type, string $className): void
    {
        $this->types[$type] = $className;

        $interfaces = \class_implements($className);
        if ($interfaces === false) {
            return;
        }
        if (\in_array(WebPageTypeInterface::class, $interfaces, true)) {
            $this->webPageTypes[] = $type;
        }
    }

    /**
     * @param array{0: Publisher, 1: non-empty-string, 2: non-empty-string} $manualProperties
     */
    public function addManualForType(string $type, array $manualProperties): void
    {
        if (! isset($this->manuals[$type])) {
            $this->manuals[$type] = [];
        }

        $this->manuals[$type][] = new Manual($manualProperties[0], $manualProperties[1], $manualProperties[2]);
    }

    /**
     * @return list<string>
     */
    public function getTypes(): array
    {
        return \array_keys($this->types);
    }

    /**
     * @return list<string>
     */
    public function getWebPageTypes(): array
    {
        return $this->webPageTypes;
    }

    /**
     * @return class-string
     */
    public function getModelClassNameForType(string $type): string
    {
        if (isset($this->types[$type])) {
            return $this->types[$type];
        }

        throw ModelClassNotFoundException::fromType($type);
    }

    /**
     * @return Manual[]
     */
    public function getManualsForType(string $type): array
    {
        if (! isset($this->manuals[$type])) {
            return [];
        }

        return $this->manuals[$type];
    }
}
