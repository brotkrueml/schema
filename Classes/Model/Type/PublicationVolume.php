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
 * A part of a successively published publication such as a periodical or multi-volume work, often numbered. It may represent a time span, such as a year.
 *
 * schema.org version 3.6
 */
class PublicationVolume extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('pageEnd', 'pageStart', 'pagination', 'volumeNumber');
    }
}
