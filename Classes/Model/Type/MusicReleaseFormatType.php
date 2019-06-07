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
 * Format of this release (the type of recording media used, ie. compact disc, digital media, LP, etc.).
 *
 * schema.org version 3.6
 */
class MusicReleaseFormatType extends Enumeration
{
    public function __construct()
    {
        parent::__construct();
    }
}
