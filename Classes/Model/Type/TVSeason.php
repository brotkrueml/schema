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
 * Season dedicated to TV broadcast and associated online delivery.
 *
 * schema.org version 3.6
 */
class TVSeason extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('actor', 'countryOfOrigin', 'director', 'endDate', 'episode', 'numberOfEpisodes', 'partOfSeries', 'productionCompany', 'seasonNumber', 'startDate', 'trailer');
    }
}
