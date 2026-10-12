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
use TYPO3Fluid\Fluid\Core\Compiler\TemplateCompiler;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ArgumentDefinition;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInterface;

/**
 * @internal
 */
final class TypeViewHelper implements ViewHelperInterface
{
    private ViewHelperNode $viewHelperNode;
    private TypeInterface $schemaType;
    private RenderingContextInterface $renderingContext;

    /**
     * @var list<RenderingContextInterface>
     */
    private array $renderingContextStack = [];

    /**
     * @var array<string, list<ArgumentDefinition>>
     */
    private static array $argumentDefinitions = [];

    /**
     * @var array<string, mixed>
     */
    private array $arguments = [];

    public function __construct(
        private TypeFactory $typeFactory,
        private SchemaTypeHandler $schemaTypeHandler,
    ) {}

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

        $typeName = $this->schemaType->getType();
        assert(is_string($typeName));

        if (! isset(self::$argumentDefinitions[$typeName])) {
            self::$argumentDefinitions[$typeName] = $this->getNotableArguments();
            foreach ($this->schemaType->getPropertyNames() as $propertyName) {
                self::$argumentDefinitions[$this->schemaType->getType()][$propertyName] = new ArgumentDefinition(
                    $propertyName,
                    'mixed',
                    \sprintf('Property "%s"', $propertyName),
                    false,
                );
            }
        }

        return self::$argumentDefinitions[$this->schemaType->getType()];
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

    public function getContentArgumentName(): null
    {
        return null;
    }

    public function setChildNodes(array $nodes): void
    {
        // Do nothing, this method is deprecated in Fluid v4 and will be removed with Fluid v5
    }

    public function setViewHelperNode(ViewHelperNode $node): void
    {
        $name = $node->getName();
        if (! \str_starts_with($name, 'type.')) {
            // There is something wrong, this should not happen
            throw new \Exception(\sprintf(
                'ViewHelper %s:%s cannot be processed by %s',
                $this->viewHelperNode->getNamespace(),
                $name,
                self::class,
            ));
        }

        $this->viewHelperNode = $node;
        $typeName = \ucfirst(\str_replace('type.', '', $name));
        $this->schemaType = $this->typeFactory->create($typeName);
    }

    public function setRenderingContext(RenderingContextInterface $renderingContext): void
    {
        $this->renderingContext = $renderingContext;
    }

    public function initializeArgumentsAndRender(): string
    {
        $this->schemaTypeHandler->addToSchema($this->schemaType, $this->arguments, $this->buildRenderChildrenClosure());

        return '';
    }

    public function handleAdditionalArguments(array $arguments): void
    {
        // We do not have to handle additional arguments
    }

    public function validateAdditionalArguments(array $arguments): void
    {
        $invalidArguments = \array_filter(
            $arguments,
            fn(string $argument) => ! \in_array($argument, $this->schemaType->getPropertyNames(), true),
            \ARRAY_FILTER_USE_KEY,
        );

        if ($invalidArguments !== []) {
            throw new Exception(
                \sprintf(
                    'Undeclared arguments passed to ViewHelper %s:%s: %s. Valid arguments are: %s',
                    $this->viewHelperNode->getNamespace(),
                    $this->viewHelperNode->getName(),
                    \implode(', ', \array_keys($arguments)),
                    \implode(', ', $this->schemaType->getPropertyNames()),
                ),
                1790604520,
            );
        }
    }

    public function setRenderChildrenClosure(\Closure $renderChildrenClosure): void
    {
        // Actually, the ViewHelperNode does not call ViewHelperInvoker with a closure,
        // this method should therefore not be called.
        throw new \Exception('Not implemented!');
    }

    public function convert(TemplateCompiler $templateCompiler): array
    {
        return [
            'initialization' => '',
            'execution' => '',
        ];
    }

    public function isChildrenEscapingEnabled(): bool
    {
        // This does not really matter as we have no output
        return true;
    }

    public function isOutputEscapingEnabled(): bool
    {
        // This does not really matter as we have no output
        return true;
    }

    public function renderChildren(): mixed
    {
        return $this->buildRenderChildrenClosure()();
    }

    private function buildRenderChildrenClosure(): \Closure
    {
        return function () {
            $this->renderingContextStack[] = $this->renderingContext;
            $result = $this->viewHelperNode->evaluateChildNodes($this->renderingContext);
            $this->setRenderingContext(\array_pop($this->renderingContextStack));

            return $result;
        };
    }
}
