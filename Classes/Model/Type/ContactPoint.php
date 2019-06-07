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
 * A contact point&#x2014;for example, a Customer Complaints department.
 *
 * schema.org version 3.6
 */
class ContactPoint extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('areaServed', 'availableLanguage', 'contactOption', 'contactType', 'email', 'faxNumber', 'hoursAvailable', 'productSupported', 'telephone');
    }
}
