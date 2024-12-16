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
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MultipleTypeViewHelper extends AbstractBaseTypeViewHelper
{
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

    public function render(): void
    {
        $this->types = GeneralUtility::trimExplode(',', $this->arguments['types'], true);
        $model = (new TypeFactory())->create(...$this->types);
        $this->addTypeToSchemaManager($model);
    }

    protected function assignPropertiesToType(): void
    {
        foreach ($this->arguments['properties'] as $name => $value) {
            $this->assignPropertyToType((string) $name, $value);
        }
    }

    protected function getType(): string
    {
        return \implode(' / ', $this->types);
    }
}
