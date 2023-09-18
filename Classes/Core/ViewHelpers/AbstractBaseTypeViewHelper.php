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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

/**
 * @internal
 */
abstract class AbstractBaseTypeViewHelper extends ViewHelper\AbstractViewHelper
{
    protected const ARGUMENT_AS = '-as';
    protected const ARGUMENT_ID = '-id';
    protected const ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE = '-isMainEntityOfWebPage';

    private int $isMainEntityOfWebPage = 0;
    private string $parentPropertyName = '';
    private ?TypeInterface $model = null;
    private readonly TypeStack $stack;
    private readonly SchemaManager $schemaManager;

    public function __construct(?TypeStack $typeStack = null, ?SchemaManager $schemaManager = null)
    {
        $this->stack = $typeStack ?? GeneralUtility::makeInstance(TypeStack::class);
        $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument(static::ARGUMENT_AS, 'string', 'Property name for a child node to merge under the parent node', false, '');
        $this->registerArgument(static::ARGUMENT_ID, 'mixed', 'IRI or a node identifier to identify the node', false, '');
        $this->registerArgument(static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE, 'int', 'Set to true, if the type is the primary content of the web page', false, false);
    }

    protected function addTypeToSchemaManager(TypeInterface $model): void
    {
        $this->model = $model;

        $this->checkAsAttribute();
        $this->checkIsMainEntityOfWebPage();
        $this->assignIdToModel();
        unset($this->arguments[static::ARGUMENT_ID]);
        $this->assignPropertiesToType();

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
            if ($this->isMainEntityOfWebPage > 0) {
                $this->schemaManager->addMainEntityOfWebPage($recent, $this->isMainEntityOfWebPage === 2);
            } else {
                $this->schemaManager->addType($recent);
            }
        }
    }

    private function checkAsAttribute(): void
    {
        if (! $this->stack->isEmpty()) {
            $parentPropertyNameFromArgument = $this->arguments[static::ARGUMENT_AS];

            if ($parentPropertyNameFromArgument === '') {
                throw new ViewHelper\Exception(
                    \sprintf(
                        'The child view helper of schema type "%s" must have an "%s" argument for embedding into the parent type',
                        $this->getType(),
                        static::ARGUMENT_AS,
                    ),
                    1561829951,
                );
            }

            $this->parentPropertyName = $parentPropertyNameFromArgument;
        }

        unset($this->arguments[static::ARGUMENT_AS]);
    }

    private function checkIsMainEntityOfWebPage(): void
    {
        $isMainEntityOfWebPage = $this->arguments[static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE] ?? 0;
        $this->isMainEntityOfWebPage = $isMainEntityOfWebPage === 'true' ? 1 : (int)$isMainEntityOfWebPage;

        if ($this->isMainEntityOfWebPage < 0 || $this->isMainEntityOfWebPage > 2) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The value of argument "%s" must be between 0 and 2, "%d" given (allowed: 0 = not a main entity, 1 = main entity, 2 = prioritised main entity',
                    static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE,
                    $this->isMainEntityOfWebPage,
                ),
                1636570950,
            );
        }

        if ($this->isMainEntityOfWebPage > 0 && ! $this->stack->isEmpty()) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The argument "%s" must not be used in the child type "%s", only the main type is allowed',
                    static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE,
                    $this->getType(),
                ),
                1562517051,
            );
        }

        unset($this->arguments[static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE]);
    }

    abstract protected function getType(): string;

    protected function assignPropertiesToType(): void
    {
        foreach ($this->arguments as $name => $value) {
            $this->assignPropertyToType($name, $value);
        }
    }

    protected function assignPropertyToType(string $name, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        if ($value === 'false') {
            $value = false;
        }

        if ($value === 'true') {
            $value = true;
        }

        $this->model->setProperty($name, $value);
    }

    private function assignIdToModel(): void
    {
        $id = $this->arguments[static::ARGUMENT_ID];
        if ($id === '') {
            return;
        }

        if (! \is_string($id) && ! $id instanceof NodeIdentifierInterface) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The %s argument has to be either a string or an instance of %s, %s given',
                    static::ARGUMENT_ID,
                    NodeIdentifierInterface::class,
                    \get_debug_type($id),
                ),
            );
        }

        $this->model->setId($this->arguments[static::ARGUMENT_ID]);
    }
}
