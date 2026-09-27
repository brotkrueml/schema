<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers;

use Brotkrueml\Schema\Core\Model\OrderedList;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Core\TypeStack;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * ViewHelper for adding an ordered list via `@list` to a property.
 * It can only be used as a child view helper for the <schema:type.xxx>
 * view helpers
 *
 * Both arguments are mandatory.
 *
 * = Examples =
 *
 * <code title="Using the view helper">
 * <f:variable name="positiveNotes" value="{
 *   0: 'Tougher and water resistant design.',
 *   1: 'Cheery bright colours and solid feel.',
 *   2: 'Excellent amplification.',
 * }"/>
 *
 * <schema:type.review name="Megaphone 11 review">
 *   <schema:orderedList -as="positiveNotes" items="{positiveNotes}"/>
 * </schema:type.review>
 * </code>
 */
final class OrderedListViewHelper extends AbstractViewHelper
{
    private const ARGUMENT_AS = '-as';
    private const ARGUMENT_ITEMS = 'items';

    public function __construct(
        private readonly TypeStack $typeStack,
    ) {}

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument(self::ARGUMENT_AS, 'string', 'Property name to merge under the parent node', true);
        $this->registerArgument(self::ARGUMENT_ITEMS, 'array', 'The items for the property', true);
    }

    public function render(): string
    {
        $this->checkAttributes();

        if ($this->typeStack->isEmpty()) {
            throw new Exception(
                'The ordered list view helper can only be used as a child of a type view helper',
                1790348202,
            );
        }

        /** @var TypeInterface $type */
        $type = $this->typeStack->pop();
        $type->addProperty($this->arguments[self::ARGUMENT_AS], new OrderedList(...$this->arguments[self::ARGUMENT_ITEMS]));
        $this->typeStack->push($type);

        return '';
    }

    private function checkAttributes(): void
    {
        $emptyMessage = 'The argument "%s" cannot be empty';

        if ($this->arguments[self::ARGUMENT_AS] === '') {
            throw new Exception(
                \sprintf($emptyMessage, self::ARGUMENT_AS),
                1790348203,
            );
        }

        if ($this->arguments[self::ARGUMENT_ITEMS] === '') {
            throw new Exception(
                \sprintf($emptyMessage, self::ARGUMENT_ITEMS),
                1790348204,
            );
        }
    }
}
