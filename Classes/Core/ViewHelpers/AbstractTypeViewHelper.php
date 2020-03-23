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
use Brotkrueml\Schema\Registry\TypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

abstract class AbstractTypeViewHelper extends ViewHelper\AbstractViewHelper
{
    protected const ARGUMENT_AS = '-as';
    protected const ARGUMENT_ID = '-id';
    protected const ARGUMENT_IS_MAIN_ENTITY_OF_WEBPAGE = '-isMainEntityOfWebPage';
    protected const ARGUMENT_SPECIFIC_TYPE = '-specificType';

    protected static $typeModel = '';

    private $item = [];

    private $isMainEntityOfWebPage = false;
    private $specificTypeModelClassName = '';

    private $parentPropertyName = '';

    /** @var TypeStack */
    private $stack;

    /** @var SchemaManager */
    private $schemaManager;

    public function __construct(TypeStack $typeStack = null, SchemaManager $schemaManager = null)
    {
        if (empty(static::$typeModel)) {
            throw new ViewHelper\Exception(
                \sprintf(
                    '%s::$typeModel must be set to the appropriate type model class',
                    __CLASS__
                ),
                1584715529
            );
        }

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

        $modelClassName = static::$typeModel;
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

    private function checkSpecificTypeAttribute(): void
    {
        $specificTypeFromArguments = (string)($this->arguments[static::ARGUMENT_SPECIFIC_TYPE] ?? '');
        unset($this->arguments[static::ARGUMENT_SPECIFIC_TYPE]);

        if (empty($specificTypeFromArguments)) {
            return;
        }

        $className = GeneralUtility::makeInstance(TypeRegistry::class)
            ->resolveModelClassFromType($specificTypeFromArguments);

        if (empty($className) || !\class_exists($className)) {
            throw new ViewHelper\Exception(
                \sprintf(
                    'The given specific type "%s" does not exist in the schema.org vocabulary, perhaps it is misspelled? Remember, the type must start with a capital letter.',
                    $specificTypeFromArguments
                ),
                1561829970
            );
        }

        $this->specificTypeModelClassName = $className;
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
        return \substr(\strrchr(static::$typeModel, '\\') ?: '', 1);
    }

    private function assignArgumentsToItem(): void
    {
        $modelClassName = $this->specificTypeModelClassName ?: static::$typeModel;

        /** @var AbstractType $model */
        $model = new $modelClassName();

        if (!empty($this->arguments[static::ARGUMENT_ID])) {
            $model->setId($this->arguments[static::ARGUMENT_ID]);
        }

        unset($this->arguments[static::ARGUMENT_ID]);

        foreach ($this->arguments as $name => $value) {
            if ($value === 'false') {
                $model->setProperty($name, false);
                continue;
            }

            if ($value === 'true') {
                $model->setProperty($name, true);
                continue;
            }

            $model->setProperty($name, $value);
        }

        $this->item = $model;
    }
}
