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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

abstract class AbstractTypeViewHelper extends ViewHelper\AbstractViewHelper
{
    protected const ARGUMENT_AS = '-as';
    protected const ARGUMENT_ID = '-id';
    protected const ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE = '-isMainEntityOfWebPage';
    protected const ARGUMENT_SPECIFIC_TYPE = '-specificType';

    /** @var bool */
    private $isMainEntityOfWebPage = false;

    /** @var string */
    private $parentPropertyName = '';

    /** @var TypeInterface */
    private $modelTemplate;

    /** @var TypeInterface */
    private $model;

    /** @var TypeStack */
    private $stack;

    /** @var SchemaManager */
    private $schemaManager;

    /** @psalm-suppress PropertyTypeCoercion */
    public function __construct(TypeStack $typeStack = null, SchemaManager $schemaManager = null)
    {
        $this->stack = $typeStack ?? GeneralUtility::makeInstance(TypeStack::class);
        $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);
        $this->modelTemplate = TypeFactory::createType($this->getType());
    }

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(static::ARGUMENT_AS, 'string', 'Property name for a child node to merge under the parent node');
        $this->registerArgument(static::ARGUMENT_ID, 'string', 'IRI to identify the node');
        $this->registerArgument(static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE, 'bool', 'Set to true, if the type is the primary content of the web page', false, false);
        $this->registerArgument(static::ARGUMENT_SPECIFIC_TYPE, 'string', 'A specific type of the chosen type. Only the properties of the chosen type are valid');

        foreach ($this->modelTemplate->getPropertyNames() as $property) {
            $this->registerArgument($property, 'mixed', 'Property ' . $property);
        }
    }

    public function render(): void
    {
        $this->model = clone $this->modelTemplate;

        $this->checkSpecificTypeAttribute();
        $this->checkAsAttribute();
        $this->checkIsMainEntityOfWebPage();

        $this->assignArgumentsToItem();

        $this->stack->push($this->model);

        $this->renderChildren();

        /** @var TypeInterface $recent */
        $recent = $this->stack->pop();

        if ($this->parentPropertyName !== '') {
            /** @var TypeInterface $parent */
            $parent = $this->stack->pop();
            $parent->addProperty($this->parentPropertyName, $recent);
            $this->stack->push($parent);
        }

        if ($this->stack->isEmpty()) {
            if ($this->isMainEntityOfWebPage) {
                $this->schemaManager->addMainEntityOfWebPage($recent);
            } else {
                $this->schemaManager->addType($recent);
            }
        }
    }

    private function checkSpecificTypeAttribute(): void
    {
        $specificTypeFromArguments = (string)($this->arguments[static::ARGUMENT_SPECIFIC_TYPE] ?? '');
        unset($this->arguments[static::ARGUMENT_SPECIFIC_TYPE]);

        if (empty($specificTypeFromArguments)) {
            return;
        }

        $this->model = TypeFactory::createType($specificTypeFromArguments);
    }

    private function checkAsAttribute(): void
    {
        if (!$this->stack->isEmpty()) {
            $parentPropertyNameFromArgument = (string)($this->arguments[static::ARGUMENT_AS] ?? '');

            if (empty($parentPropertyNameFromArgument)) {
                throw new ViewHelper\Exception(
                    \sprintf(
                        'The child view helper of schema type "%s" must have an "%s" argument for embedding into the parent type',
                        $this->getType(),
                        static::ARGUMENT_AS
                    ),
                    1561829951
                );
            }

            $this->parentPropertyName = $parentPropertyNameFromArgument;
        }

        unset($this->arguments[static::ARGUMENT_AS]);
    }

    private function checkIsMainEntityOfWebPage(): void
    {
        $this->isMainEntityOfWebPage = (bool)($this->arguments[static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE] ?? false);

        if ($this->isMainEntityOfWebPage && !$this->stack->isEmpty()) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The argument "%s" must not be used in the child type "%s", only the main type is allowed',
                    static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE,
                    $this->getType()
                ),
                1562517051
            );
        }

        unset($this->arguments[static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE]);
    }

    private function getType(): string
    {
        return \str_replace(
            'ViewHelper',
            '',
            \substr(\strrchr(static::class, '\\') ?: '', 1)
        );
    }

    private function assignArgumentsToItem(): void
    {
        if (!empty($this->arguments[static::ARGUMENT_ID])) {
            $this->model->setId($this->arguments[static::ARGUMENT_ID]);
        }

        unset($this->arguments[static::ARGUMENT_ID]);

        foreach ($this->arguments as $name => $value) {
            if ($value === null) {
                continue;
            }

            if ($value === 'false') {
                $this->model->setProperty($name, false);
                continue;
            }

            if ($value === 'true') {
                $this->model->setProperty($name, true);
                continue;
            }

            $this->model->setProperty($name, $value);
        }
    }
}
