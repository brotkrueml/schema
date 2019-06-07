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
 * A set of requirements that a must be fulfilled in order to perform an Action.
 *
 * schema.org version 3.6
 */
class ActionAccessSpecificationViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('availabilityEnds', 'mixed', 'The end of the availability of the product or service included in the offer.');
        $this->registerArgument('availabilityStarts', 'mixed', 'The beginning of the availability of the product or service included in the offer.');
        $this->registerArgument('category', 'mixed', 'A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.');
        $this->registerArgument('eligibleRegion', 'mixed', 'The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, the place, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.');
        $this->registerArgument('expectsAcceptanceOf', 'mixed', 'An Offer which must be accepted before the user can perform the Action. For example, the user may need to buy a movie before being able to watch it.');
        $this->registerArgument('requiresSubscription', 'mixed', 'Indicates if use of the media require a subscription  (either paid or free). Allowed values are true or false (note that an earlier version had \'yes\', \'no\').');
    }
}
