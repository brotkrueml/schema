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
 * A means for accessing a service, e.g. a government office location, web site, or phone number.
 *
 * schema.org version 3.6
 */
class ServiceChannel extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('availableLanguage', 'processingTime', 'providesService', 'serviceLocation', 'servicePhone', 'servicePostalAddress', 'serviceSmsNumber', 'serviceUrl');
    }
}
