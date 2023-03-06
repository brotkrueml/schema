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
}
