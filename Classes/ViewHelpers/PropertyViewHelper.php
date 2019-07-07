<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelpers;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\TypeStack;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

/**
 * ViewHelper for adding a property with a string value to a
 * schema type. It can only be used as a child view helper for a
 * <schema:type.thing> or equivalent.
 *
 * Both arguments are mandatory.
 *
 * = Examples =
 * <code title="Using the view helper">
 * <schema:property -as="sameAs" value="https://twitter.com/example">
 * </code>
 */
class PropertyViewHelper extends ViewHelper\AbstractViewHelper
{
    protected const ARGUMENT_AS = '-as';
    protected const ARGUMENT_VALUE = 'value';

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(static::ARGUMENT_AS, 'string', 'Property name to merge under the parent node', true);
        $this->registerArgument(static::ARGUMENT_VALUE, 'string', 'The value of the property', true);
    }

    public function render()
    {
        $this->checkAttributes();

        $stack = GeneralUtility::makeInstance(TypeStack::class);

        if ($stack->isEmpty()) {
            throw new ViewHelper\Exception(
                'The property view helper can only be used as a child of a type view helper',
                1561838013
            );
        }

        $type = $stack->pop();
        $type->addProperty($this->arguments[static::ARGUMENT_AS], $this->arguments[static::ARGUMENT_VALUE]);
        $stack->push($type);
    }

    protected function checkAttributes(): void
    {
        $emptyMessage = 'The argument "%s" cannot be empty';

        if (empty($this->arguments[static::ARGUMENT_AS])) {
            throw new ViewHelper\Exception(
                \sprintf($emptyMessage, static::ARGUMENT_AS),
                1561838834
            );
        }

        if (empty($this->arguments[static::ARGUMENT_VALUE])) {
            throw new ViewHelper\Exception(
                \sprintf($emptyMessage, static::ARGUMENT_VALUE),
                1561838999
            );
        }
    }
}
