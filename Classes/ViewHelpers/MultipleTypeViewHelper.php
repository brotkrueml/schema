<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractBaseTypeViewHelper;
use Brotkrueml\Schema\Core\ViewHelpers\SchemaTypeHandler;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MultipleTypeViewHelper extends AbstractBaseTypeViewHelper
{
    public function __construct(
        private readonly TypeFactory $typeFactory,
        private readonly SchemaTypeHandler $typeProcessor,
    ) {}

    /**
     * @var list<string>
     */
    private array $types = [];

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('types', 'string', 'The different types delimited by a comma', true);
        $this->registerArgument('properties', 'array', 'The properties for the multiple type', false, []);
    }

    public function render(): string
    {
        $this->types = GeneralUtility::trimExplode(',', $this->arguments['types'], true);
        $model = $this->typeFactory->create(...$this->types);
        $this->typeProcessor->addToSchema(
            $model,
            [
                ...\array_filter($this->arguments, static fn(string $key): bool => \str_starts_with($key, '-'), \ARRAY_FILTER_USE_KEY),
                ...$this->arguments['properties'],
            ],
            $this->buildRenderChildrenClosure(),
        );

        return '';
    }

    protected function getType(): string
    {
        return \implode(' / ', $this->types);
    }
}
