<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\ViewHelpers;

use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Core\TypeStack;
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * @internal
 */
final readonly class SchemaTypeHandler
{
    public function __construct(
        private SchemaManager $schemaManager,
        private TypeStack $typeStack,
    ) {}

    /**
     * @param array<string, mixed> $arguments
     */
    public function addToSchema(TypeInterface $type, array $arguments, \Closure $renderChildrenClosure): void
    {
        $parentPropertyName = $this->getParentPropertyName($type, $arguments);
        $isMainEntityOfWebPage = $this->getIsMainEntityOfWebPage($type, $arguments);
        $type->setId($this->getId($arguments));

        unset($arguments[NotableArgument::As->value]);
        unset($arguments[NotableArgument::Id->value]);
        unset($arguments[NotableArgument::IsMainEntityOfWebPage->value]);

        $this->assignPropertiesToType($type, $arguments);

        $this->typeStack->push($type);

        $renderChildrenClosure();

        /** @var TypeInterface $recent */
        $recent = $this->typeStack->pop();

        if ($parentPropertyName !== '') {
            /** @var TypeInterface $parent */
            $parent = $this->typeStack->pop();
            $parent->addProperty($parentPropertyName, $recent);
            $this->typeStack->push($parent);
        }

        if ($this->typeStack->isEmpty()) {
            if ($isMainEntityOfWebPage > 0) {
                $this->schemaManager->addMainEntityOfWebPage($recent, $isMainEntityOfWebPage === 2);
            } else {
                $this->schemaManager->addType($recent);
            }
        }
    }

    /**
     * @param array<string, mixed> $arguments
     */
    private function getParentPropertyName(TypeInterface $type, array $arguments): string
    {
        if (! $this->typeStack->isEmpty()) {
            $parentPropertyNameFromArgument = $arguments[NotableArgument::As->value] ?? '';

            if ($parentPropertyNameFromArgument === '') {
                throw new Exception(
                    \sprintf(
                        'The child view helper of schema type "%s" must have an "%s" argument for embedding into the parent type',
                        $this->getDebugValueForType($type),
                        NotableArgument::As->value,
                    ),
                    1561829951,
                );
            }

            return $parentPropertyNameFromArgument;
        }

        return '';
    }

    /**
     * @param array<string, mixed> $arguments
     */
    private function getIsMainEntityOfWebPage(TypeInterface $type, array $arguments): int
    {
        $isMainEntityOfWebPageFromArgument = $arguments[NotableArgument::IsMainEntityOfWebPage->value] ?? 0;
        $isMainEntityOfWebPage = match ($isMainEntityOfWebPageFromArgument) {
            'true', true => 1,
            'false', false => 0,
            default => (int) $isMainEntityOfWebPageFromArgument,
        };

        if ($isMainEntityOfWebPage < 0 || $isMainEntityOfWebPage > 2) {
            throw new Exception(
                \sprintf(
                    'The value of argument "%s" must be between 0 and 2, "%d" given (allowed: 0 = not a main entity, 1 = main entity, 2 = prioritised main entity',
                    NotableArgument::IsMainEntityOfWebPage->value,
                    $isMainEntityOfWebPage,
                ),
                1636570950,
            );
        }

        if ($isMainEntityOfWebPage > 0 && ! $this->typeStack->isEmpty()) {
            throw new Exception(
                \sprintf(
                    'The argument "%s" must not be used in the child type "%s", only the main type is allowed',
                    NotableArgument::IsMainEntityOfWebPage->value,
                    $this->getDebugValueForType($type),
                ),
                1562517051,
            );
        }

        return $isMainEntityOfWebPage;
    }

    /**
     * @param array<string, mixed> $arguments
     */
    private function getId(array $arguments): NodeIdentifierInterface|string
    {
        $id = $arguments[NotableArgument::Id->value] ?? '';

        if (! \is_string($id) && ! $id instanceof NodeIdentifierInterface) {
            throw new Exception(
                \sprintf(
                    'The %s argument has to be either a string, an instance of %s or null, %s given',
                    NotableArgument::Id->value,
                    NodeIdentifierInterface::class,
                    \get_debug_type($id),
                ),
                1790700914,
            );
        }

        return $id;
    }

    /**
     * @param array<string, mixed> $arguments
     */
    private function assignPropertiesToType(TypeInterface $type, array $arguments): void
    {
        foreach ($arguments as $name => $value) {
            if ($value === null) {
                continue;
            }

            if ($value === 'false') {
                $value = false;
            }

            if ($value === 'true') {
                $value = true;
            }

            $type->setProperty($name, $value);
        }
    }

    private function getDebugValueForType(TypeInterface $type): string
    {
        return \is_array($type->getType()) ? \implode(' / ', $type->getType()) : $type->getType();
    }
}
