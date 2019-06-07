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
 * A predefined value for a product characteristic, e.g. the power cord plug type \'US\' or the garment sizes \'S\', \'M\', \'L\', and \'XL\'.
 *
 * schema.org version 3.6
 */
class QualitativeValueViewHelper extends EnumerationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalProperty', 'mixed', 'A property-value pair representing an additional characteristics of the entitity, e.g. a product feature or another characteristic for which there is no matching property in schema.org.');
        $this->registerArgument('equal', 'mixed', 'This ordering relation for qualitative values indicates that the subject is equal to the object.');
        $this->registerArgument('greater', 'mixed', 'This ordering relation for qualitative values indicates that the subject is greater than the object.');
        $this->registerArgument('greaterOrEqual', 'mixed', 'This ordering relation for qualitative values indicates that the subject is greater than or equal to the object.');
        $this->registerArgument('lesser', 'mixed', 'This ordering relation for qualitative values indicates that the subject is lesser than the object.');
        $this->registerArgument('lesserOrEqual', 'mixed', 'This ordering relation for qualitative values indicates that the subject is lesser than or equal to the object.');
        $this->registerArgument('nonEqual', 'mixed', 'This ordering relation for qualitative values indicates that the subject is not equal to the object.');
        $this->registerArgument('valueReference', 'mixed', 'A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.');
    }
}
