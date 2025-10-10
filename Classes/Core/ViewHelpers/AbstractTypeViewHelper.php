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
use Brotkrueml\Schema\Core\TypeStack;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;

abstract class AbstractTypeViewHelper extends AbstractBaseTypeViewHelper
{
    protected const ARGUMENT_SPECIFIC_TYPE = '-specificType';

    private readonly TypeInterface $modelTemplate;

    public function __construct(
        TypeStack $stack,
        SchemaManager $schemaManager,
        private readonly TypeFactory $typeFactory,
    ) {
        parent::__construct($stack, $schemaManager);
        $this->modelTemplate = $this->typeFactory->create($this->getType());
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument(static::ARGUMENT_SPECIFIC_TYPE, 'string', 'A specific type of the chosen type. Only the properties of the chosen type are valid', false, '');

        foreach ($this->modelTemplate->getPropertyNames() as $property) {
            $this->registerArgument($property, 'mixed', 'Property ' . $property);
        }
    }

    public function render(): string
    {
        $model = $this->getSpecificTypeIfDefined() ?? clone $this->modelTemplate;
        $this->addTypeToSchemaManager($model);

        return '';
    }

    private function getSpecificTypeIfDefined(): ?TypeInterface
    {
        $specificTypeFromArguments = $this->arguments[static::ARGUMENT_SPECIFIC_TYPE];
        unset($this->arguments[static::ARGUMENT_SPECIFIC_TYPE]);

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
