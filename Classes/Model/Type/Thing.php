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
 * The most generic type of item.
 *
 * schema.org version 3.6
 */
class Thing extends \Brotkrueml\Schema\Core\Model\AbstractType
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('additionalType', 'alternateName', 'description', 'disambiguatingDescription', 'identifier', 'image', 'mainEntityOfPage', 'name', 'potentialAction', 'sameAs', 'subjectOf', 'url');
    }
}
