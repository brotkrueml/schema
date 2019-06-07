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
 * A food-related business.
 *
 * schema.org version 3.6
 */
class FoodEstablishmentViewHelper extends LocalBusinessViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('acceptsReservations', 'mixed', 'Indicates whether a FoodEstablishment accepts reservations. Values can be Boolean, an URL at which reservations can be made or (for backwards compatibility) the strings Yes or No.');
        $this->registerArgument('hasMenu', 'mixed', 'Either the actual menu as a structured representation, as text, or a URL of the menu.');
        $this->registerArgument('servesCuisine', 'mixed', 'The cuisine of the restaurant.');
        $this->registerArgument('starRating', 'mixed', 'An official rating for a lodging business or food establishment, e.g. from national associations or standards bodies. Use the author property to indicate the rating organization, e.g. as an Organization with name such as (e.g. HOTREC, DEHOGA, WHR, or Hotelstars).');
    }
}
