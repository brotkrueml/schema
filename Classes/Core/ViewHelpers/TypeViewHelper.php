<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\ViewHelpers;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\ArgumentDefinition;

/**
 * @internal
 */
final class TypeViewHelper extends AbstractViewHelper
{
    private TypeInterface $schemaType;

    /**
     * @var array<string, list<ArgumentDefinition>>
     */
    private static array $typeArgumentDefinitions = [];

    public function __construct(
        private readonly TypeFactory $typeFactory,
        private readonly SchemaTypeHandler $schemaTypeHandler,
    ) {}

    /**
     * @param array<string, mixed> $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
        if ($this->arguments[NotableArgument::SpecificType->value] !== '') {
            $this->schemaType = $this->typeFactory->create($this->arguments[NotableArgument::SpecificType->value]);
        }
    }

    /**
     * @return list<ArgumentDefinition>
     */
    public function prepareArguments(): array
    {
        $name = $this->viewHelperNode->getName();
        if (! \str_starts_with($name, 'type.')) {
            // There is something wrong, this should not happen
            throw new \Exception(\sprintf(
                'ViewHelper %s:%s should not be processed by %s',
                $this->viewHelperNode->getNamespace(),
                $name,
                self::class,
            ));
        }

        $typeName = \ucfirst(\str_replace('type.', '', $name));
        $this->schemaType = $this->typeFactory->create($typeName);

        if (! isset(self::$typeArgumentDefinitions[$typeName])) {
            self::$typeArgumentDefinitions[$typeName] = $this->getNotableArguments();
            foreach ($this->schemaType->getPropertyNames() as $propertyName) {
                self::$typeArgumentDefinitions[$this->schemaType->getType()][$propertyName] = new ArgumentDefinition(
                    $propertyName,
                    'mixed',
                    \sprintf('Property "%s"', $propertyName),
                    false,
                );
            }
        }

        return self::$typeArgumentDefinitions[$this->schemaType->getType()];
    }

    /**
     * @return array<string, list<ArgumentDefinition>>
     */
    private function getNotableArguments(): array
    {
        static $notableArguments = [];

        if ($notableArguments === []) {
            foreach (NotableArgument::cases() as $argument) {
                $notableArguments[$argument->value] = new ArgumentDefinition(
                    $argument->value,
                    $argument->type(),
                    $argument->description(),
                    false,
                    $argument->default(),
                );
            }
        }

        return $notableArguments;
    }

    public function render(): string
    {
        $this->schemaTypeHandler->addToSchema($this->schemaType, $this->arguments, $this->buildRenderChildrenClosure());

        return '';
    }
}
