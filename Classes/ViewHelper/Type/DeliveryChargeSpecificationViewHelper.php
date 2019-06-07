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
 * The price for the delivery of an offer using a particular delivery method.
 *
 * schema.org version 3.6
 */
class DeliveryChargeSpecificationViewHelper extends PriceSpecificationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('appliesToDeliveryMethod', 'mixed', 'The delivery method(s) to which the delivery charge or payment charge specification applies.');
        $this->registerArgument('areaServed', 'mixed', 'The geographic area where a service or offered item is provided.');
        $this->registerArgument('eligibleRegion', 'mixed', 'The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, the place, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.');
        $this->registerArgument('ineligibleRegion', 'mixed', 'The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, the place, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is not valid, e.g. a region where the transaction is not allowed.');
    }
}
