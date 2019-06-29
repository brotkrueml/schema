<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\ViewHelper;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Utility\Utility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

abstract class AbstractTypeViewHelper extends ViewHelper\AbstractViewHelper
{
    protected const CONTEXT = 'http://schema.org';

    protected const ARGUMENT_ID = '-id';
    protected const ARGUMENT_AS = '-as';
    protected const ARGUMENT_SPECIFIC_TYPE = '-specificType';

    protected $item = [];

    protected $specificType;
    protected $parentPropertyName;

    /** @var \SplStack */
    protected static $stack;

    public function initialize()
    {
        if (!static::$stack) {
            static::$stack = new \SplStack();
        }
    }

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(static::ARGUMENT_ID, 'string', 'IRI to identify the node');
        $this->registerArgument(static::ARGUMENT_AS, 'string', 'Property name for a child node to merge under the parent node');
        $this->registerArgument(static::ARGUMENT_SPECIFIC_TYPE, 'string', 'A specific type of the chosen type. Only the properties of the chosen type are valid');

        $modelClassName = '\\Brotkrueml\\Schema\\Model\\Type\\' . $this->getType();
        /** @var AbstractType $model */
        $model = new $modelClassName();
        foreach ($model->getProperties() as $property) {
            $this->registerArgument($property, 'mixed', 'Property ' . $property);
        }
    }

    public function render()
    {
        $this->checkSpecificTypeAttribute();
        $this->checkAsAttribute();

        $this->assignArgumentsToItem();

        static::$stack->push($this->item);

        $this->renderChildren();

        /** @var AbstractType $recent */
        $recent = static::$stack->pop();

        if ($this->parentPropertyName) {
            /** @var AbstractType $parent */
            $parent = static::$stack->pop();
            $parent->addProperty($this->parentPropertyName, $recent);
            static::$stack->push($parent);
        }

        if (static::$stack->isEmpty()) {
            /** @var SchemaManager $schemaManager */
            $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
            $schemaManager->addType($recent);
        }
    }

    protected function checkSpecificTypeAttribute(): void
    {
        $specificType = (string)($this->arguments[static::ARGUMENT_SPECIFIC_TYPE] ?? '');

        if (empty($specificType)) {
            return;
        }

        $className = '\\Brotkrueml\\Schema\\ViewHelper\\Type\\' . $specificType . 'ViewHelper';

        if (!\class_exists($className)) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The given specific type "%s" does not exist in the schema.org vocabulary, perhaps it is misspelled? Remember, the type must start with a capital letter.',
                    $specificType
                ),
                1561829970
            );
        }

        $this->specificType = $specificType;

        unset($this->arguments[static::ARGUMENT_SPECIFIC_TYPE]);
    }

    protected function checkAsAttribute(): void
    {
        if (!static::$stack->isEmpty()) {
            $parentPropertyName = (string)($this->arguments[static::ARGUMENT_AS] ?? '');

            if (empty($parentPropertyName)) {
                throw new ViewHelper\Exception(
                    \sprintf(
                        'The child view helper of schema type "%s" must have an "%s" attribute for embedding into the parent type',
                        $this->getType(),
                        static::ARGUMENT_AS
                    ),
                    1561829951
                );
            }

            $this->parentPropertyName = $parentPropertyName;
        }

        unset($this->arguments[static::ARGUMENT_AS]);
    }

    protected function getType(): string
    {
        if (!empty($this->specificType)) {
            return $this->specificType;
        }

        return \str_replace('ViewHelper', '', Utility::getClassNameWithoutNamespace(static::class));
    }

    protected function assignArgumentsToItem(): void
    {
        $modelClassName = '\\Brotkrueml\\Schema\\Model\\Type\\' . $this->getType();

        /** @var AbstractType $model */
        $model = new $modelClassName();

        if (!empty($this->arguments[static::ARGUMENT_ID])) {
            $model->setId($this->arguments[static::ARGUMENT_ID]);
        }

        unset($this->arguments[static::ARGUMENT_ID]);

        foreach ($this->arguments as $name => $value) {
            if (empty($value)) {
                continue;
            }

            $model->setProperty($name, $value);
        }

        $this->item = $model;
    }
}
