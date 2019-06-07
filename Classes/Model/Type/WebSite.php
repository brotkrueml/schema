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
 * A WebSite is a set of related web pages and other items typically served from a single web domain and accessible via URLs.
 *
 * schema.org version 3.6
 */
class WebSite extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('issn');
    }
}
