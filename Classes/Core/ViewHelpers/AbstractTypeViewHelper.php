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

    private TypeInterface $modelTemplate;

    public function __construct(TypeStack $typeStack = null, SchemaManager $schemaManager = null)
    {
        parent::__construct($typeStack, $schemaManager);
        $this->modelTemplate = TypeFactory::createType($this->getType());
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument(static::ARGUMENT_SPECIFIC_TYPE, 'string', 'A specific type of the chosen type. Only the properties of the chosen type are valid', false, '');

        foreach ($this->modelTemplate->getPropertyNames() as $property) {
            $this->registerArgument($property, 'mixed', 'Property ' . $property);
        }
    }

    public function render(): void
    {
        $model = $this->getSpecificTypeIfDefined() ?? clone $this->modelTemplate;
        $this->addTypeToSchemaManager($model);
    }

    private function getSpecificTypeIfDefined(): ?TypeInterface
    {
        $specificTypeFromArguments = $this->arguments[static::ARGUMENT_SPECIFIC_TYPE];
        unset($this->arguments[static::ARGUMENT_SPECIFIC_TYPE]);

        if ($specificTypeFromArguments === '') {
            return null;
        }

        return TypeFactory::createType($specificTypeFromArguments);
    }

    protected function getType(): string
    {
        return \str_replace(
            'ViewHelper',
            '',
            \substr(\strrchr(static::class, '\\') ?: '', 1)
        );
    }
}
