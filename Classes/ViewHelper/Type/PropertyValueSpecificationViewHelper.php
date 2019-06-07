<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A Property value specification.
 *
 * schema.org version 3.6
 */
class PropertyValueSpecificationViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('defaultValue', 'mixed', 'The default value of the input.  For properties that expect a literal, the default is a literal value, for properties that expect an object, it\'s an ID reference to one of the current values.');
        $this->registerArgument('maxValue', 'mixed', 'The upper value of some characteristic or property.');
        $this->registerArgument('minValue', 'mixed', 'The lower value of some characteristic or property.');
        $this->registerArgument('multipleValues', 'mixed', 'Whether multiple values are allowed for the property.  Default is false.');
        $this->registerArgument('readonlyValue', 'mixed', 'Whether or not a property is mutable.  Default is false. Specifying this for a property that also has a value makes it act similar to a "hidden" input in an HTML form.');
        $this->registerArgument('stepValue', 'mixed', 'The stepValue attribute indicates the granularity that is expected (and required) of the value in a PropertyValueSpecification.');
        $this->registerArgument('valueMaxLength', 'mixed', 'Specifies the allowed range for number of characters in a literal value.');
        $this->registerArgument('valueMinLength', 'mixed', 'Specifies the minimum allowed range for number of characters in a literal value.');
        $this->registerArgument('valueName', 'mixed', 'Indicates the name of the PropertyValueSpecification to be used in URL templates and form encoding in a manner analogous to HTML\'s input@name.');
        $this->registerArgument('valuePattern', 'mixed', 'Specifies a regular expression for testing literal values according to the HTML spec.');
        $this->registerArgument('valueRequired', 'mixed', 'Whether the property must be filled in to complete the action.  Default is false.');
    }
}
