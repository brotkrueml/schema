<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers;

use Brotkrueml\Schema\Core\Model\BlankNodeIdentifier;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper for creating a BlankNodeIdentifier.
 * Best way it is to assign the value to a variable to use
 * it multiple times. You can use that variable to
 * assign it to the "-id" property of a type view helper.
 * The view helper has no arguments.
 *
 * = Example =
 * <code title="Using the view helper">
 * <f:variable name="blankIdentifier1" value="{schema:blankNodeIdentifier()}"/>
 * <f:variable name="blankIdentifier2" value="{schema:blankNodeIdentifier()}"/>
 * <schema:type.person name="John Smith" -id="{blankIdentifier1}" knows="{blankIdentifier2}"/>
 * <schema:type.person name="Sarah Jane Smith" -id="{blankIdentifier2}" knows="{blankIdentifier1}"/>
 * </code>
 */
final class BlankNodeIdentifierViewHelper extends AbstractViewHelper
{
    public function render(): BlankNodeIdentifier
    {
        return new BlankNodeIdentifier();
    }
}
