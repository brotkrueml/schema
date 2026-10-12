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

abstract class AbstractTypeViewHelper extends AbstractBaseTypeViewHelper
{
    private readonly TypeInterface $modelTemplate;

    public function __construct(
        private readonly TypeFactory $typeFactory,
        private readonly SchemaTypeHandler $schemaTypeHandler,
    ) {
        $this->modelTemplate = $this->typeFactory->create($this->getType());
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument(
            NotableArgument::SpecificType->value,
            NotableArgument::SpecificType->type(),
            NotableArgument::SpecificType->description(),
            false,
            NotableArgument::SpecificType->default(),
        );

        foreach ($this->modelTemplate->getPropertyNames() as $property) {
            $this->registerArgument($property, 'mixed', 'Property ' . $property);
        }
    }

    public function render(): string
    {
        $model = $this->getSpecificTypeIfDefined() ?? clone $this->modelTemplate;
        $this->schemaTypeHandler->addToSchema($model, $this->arguments, $this->buildRenderChildrenClosure());

        return '';
    }

    private function getSpecificTypeIfDefined(): ?TypeInterface
    {
        $specificTypeFromArguments = $this->arguments[NotableArgument::SpecificType->value];
        if ($specificTypeFromArguments === '') {
            return null;
        }

        return $this->typeFactory->create($specificTypeFromArguments);
    }

    protected function getType(): string
    {
        return $this->type;
    }
}
