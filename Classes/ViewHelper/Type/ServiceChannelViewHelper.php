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
 * A means for accessing a service, e.g. a government office location, web site, or phone number.
 *
 * schema.org version 3.6
 */
class ServiceChannelViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('availableLanguage', 'mixed', 'A language someone may use with or at the item, service or place. Please use one of the language codes from the IETF BCP 47 standard. See also inLanguage');
        $this->registerArgument('processingTime', 'mixed', 'Estimated processing time for the service using this channel.');
        $this->registerArgument('providesService', 'mixed', 'The service provided by this channel.');
        $this->registerArgument('serviceLocation', 'mixed', 'The location (e.g. civic structure, local business, etc.) where a person can go to access the service.');
        $this->registerArgument('servicePhone', 'mixed', 'The phone number to use to access the service.');
        $this->registerArgument('servicePostalAddress', 'mixed', 'The address for accessing the service by mail.');
        $this->registerArgument('serviceSmsNumber', 'mixed', 'The number to access the service by text message.');
        $this->registerArgument('serviceUrl', 'mixed', 'The website to access the service.');
    }
}
