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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * @internal
 */
abstract class AbstractBaseTypeViewHelper extends AbstractViewHelper
{
    protected string $type = '';

    private int $isMainEntityOfWebPage = 0;
    private string $parentPropertyName = '';
    private ?TypeInterface $model = null;

    public function __construct(
        private readonly TypeStack $stack,
        private readonly SchemaManager $schemaManager,
    ) {}

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        foreach (NotableArgument::cases() as $argument) {
            $this->registerArgument(
                $argument->value,
                $argument->type(),
                $argument->description(),
                false,
                $argument->default(),
            );
        }
    }

    protected function addTypeToSchemaManager(TypeInterface $model): void
    {
        $this->model = $model;

        $this->checkAsAttribute();
        $this->checkIsMainEntityOfWebPage();
        $this->assignIdToModel();
        unset($this->arguments[NotableArgument::Id->value]);
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
            $parentPropertyNameFromArgument = $this->arguments[NotableArgument::As->value];

            if ($parentPropertyNameFromArgument === '') {
                throw new Exception(
                    \sprintf(
                        'The child view helper of schema type "%s" must have an "%s" argument for embedding into the parent type',
                        $this->getType(),
                        NotableArgument::As->value,
                    ),
                    1561829951,
                );
            }

            $this->parentPropertyName = $parentPropertyNameFromArgument;
        }

        unset($this->arguments[NotableArgument::As->value]);
    }

    private function checkIsMainEntityOfWebPage(): void
    {
        $isMainEntityOfWebPage = $this->arguments[NotableArgument::IsMainEntityOfWebPage->value] ?? 0;
        $this->isMainEntityOfWebPage = match ($isMainEntityOfWebPage) {
            'true', true => 1,
            'false', false => 0,
            default => (int) $isMainEntityOfWebPage,
        };

        if ($this->isMainEntityOfWebPage < 0 || $this->isMainEntityOfWebPage > 2) {
            throw new Exception(
                \sprintf(
                    'The value of argument "%s" must be between 0 and 2, "%d" given (allowed: 0 = not a main entity, 1 = main entity, 2 = prioritised main entity',
                    NotableArgument::IsMainEntityOfWebPage->value,
                    $this->isMainEntityOfWebPage,
                ),
                1636570950,
            );
        }

        if ($this->isMainEntityOfWebPage > 0 && ! $this->stack->isEmpty()) {
            throw new Exception(
                \sprintf(
                    'The argument "%s" must not be used in the child type "%s", only the main type is allowed',
                    NotableArgument::IsMainEntityOfWebPage->value,
                    $this->getType(),
                ),
                1562517051,
            );
        }

        unset($this->arguments[NotableArgument::IsMainEntityOfWebPage->value]);
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
        $id = $this->arguments[NotableArgument::Id->value];
        if ($id === '') {
            return;
        }

        if (! \is_string($id) && ! $id instanceof NodeIdentifierInterface) {
            throw new Exception(
                \sprintf(
                    'The %s argument has to be either a string or an instance of %s, %s given',
                    NotableArgument::Id->value,
                    NodeIdentifierInterface::class,
                    \get_debug_type($id),
                ),
            );
        }

        $this->model->setId($id);
    }
}
