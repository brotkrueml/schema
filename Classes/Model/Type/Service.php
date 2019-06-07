<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A service provided by an organization, e.g. delivery service, print services, etc.
 *
 * schema.org version 3.6
 */
class Service extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('aggregateRating', 'areaServed', 'audience', 'availableChannel', 'award', 'brand', 'broker', 'category', 'hasOfferCatalog', 'hoursAvailable', 'isRelatedTo', 'isSimilarTo', 'logo', 'offers', 'provider', 'providerMobility', 'review', 'serviceOutput', 'serviceType', 'slogan');
    }
}
