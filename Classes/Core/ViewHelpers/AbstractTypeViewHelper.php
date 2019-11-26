<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Core\ViewHelpers;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\TypeStack;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Utility\Utility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

abstract class AbstractTypeViewHelper extends ViewHelper\AbstractViewHelper
{
    protected const CONTEXT = 'http://schema.org';

    protected const ARGUMENT_AS = '-as';
    protected const ARGUMENT_ID = '-id';
    protected const ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE = '-isMainEntityOfWebPage';
    protected const ARGUMENT_SPECIFIC_TYPE = '-specificType';

    protected $item = [];

    protected $isMainEntityOfWebPage = false;
    protected $specificType = '';

    protected $parentPropertyName = '';

    /** @var TypeStack */
    protected $stack;

    /** @var SchemaManager */
    protected $schemaManager;

    public function __construct(TypeStack $typeStack = null, SchemaManager $schemaManager = null)
    {
        $this->stack = $typeStack ?: GeneralUtility::makeInstance(TypeStack::class);
        $this->schemaManager = $schemaManager ?: GeneralUtility::makeInstance(SchemaManager::class);
    }

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(static::ARGUMENT_AS, 'string', 'Property name for a child node to merge under the parent node');
        $this->registerArgument(static::ARGUMENT_ID, 'string', 'IRI to identify the node');
        $this->registerArgument(static::ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE, 'bool', 'Set to true, if the type is the primary content of the web page', false, false);
        $this->registerArgument(static::ARGUMENT_SPECIFIC_TYPE, 'string', 'A specific type of the chosen type. Only the properties of the chosen type are valid');

        $modelClassName = Utility::getNamespacedClassNameForType($this->getType());
        /** @var AbstractType $model */
        $model = new $modelClassName();
        foreach ($model->getPropertyNames() as $property) {
            $this->registerArgument($property, 'mixed', 'Property ' . $property);
        }
    }

    public function render()
    {
        $this->checkSpecificTypeAttribute();
        $this->checkAsAttribute();
        $this->checkIsMainEntityOfWebPage();

        $this->assignArgumentsToItem();

        $this->stack->push($this->item);

        $this->renderChildren();

        /** @var AbstractType $recent */
        $recent = $this->stack->pop();

        if ($this->parentPropertyName) {
            /** @var AbstractType $parent */
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

    protected function checkSpecificTypeAttribute(): void
    {
        $specificTypeFromArguments = (string)($this->arguments[static::ARGUMENT_SPECIFIC_TYPE] ?? '');
        unset($this->arguments[static::ARGUMENT_SPECIFIC_TYPE]);

        if (empty($specificTypeFromArguments)) {
            return;
        }

        $className = '\\Brotkrueml\\Schema\\ViewHelpers\\Type\\' . $specificTypeFromArguments . 'ViewHelper';

        if (!\class_exists($className)) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The given specific type "%s" does not exist in the schema.org vocabulary, perhaps it is misspelled? Remember, the type must start with a capital letter.',
                    $specificTypeFromArguments
                ),
                1561829970
            );
        }

        $this->specificType = $specificTypeFromArguments;
    }

    protected function checkAsAttribute(): void
    {
        if (!$this->stack->isEmpty()) {
            $parentPropertyNameFromArgument = (string)($this->arguments[static::ARGUMENT_AS] ?? '');

            if (empty($parentPropertyNameFromArgument)) {
                throw new ViewHelper\Exception(
                    \sprintf(
                        'The child view helper of schema type "%s" must have an "%s" attribute for embedding into the parent type',
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

    protected function checkIsMainEntityOfWebPage(): void
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

    protected function getType(): string
    {
        if (!empty($this->specificType)) {
            return $this->specificType;
        }

        return \str_replace('ViewHelper', '', Utility::getClassNameWithoutNamespace(static::class));
    }

    protected function assignArgumentsToItem(): void
    {
        $modelClassName = Utility::getNamespacedClassNameForType($this->getType());

        /** @var AbstractType $model */
        $model = new $modelClassName();

        if (!empty($this->arguments[static::ARGUMENT_ID])) {
            $model->setId($this->arguments[static::ARGUMENT_ID]);
        }

        unset($this->arguments[static::ARGUMENT_ID]);

        foreach ($this->arguments as $name => $value) {
            $model->setProperty($name, $value);
        }

        $this->item = $model;
    }
}
