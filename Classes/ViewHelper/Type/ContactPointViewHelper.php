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
 * A contact point&#x2014;for example, a Customer Complaints department.
 *
 * schema.org version 3.6
 */
class ContactPointViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('areaServed', 'mixed', 'The geographic area where a service or offered item is provided.');
        $this->registerArgument('availableLanguage', 'mixed', 'A language someone may use with or at the item, service or place. Please use one of the language codes from the IETF BCP 47 standard. See also inLanguage');
        $this->registerArgument('contactOption', 'mixed', 'An option available on this contact point (e.g. a toll-free number or support for hearing-impaired callers).');
        $this->registerArgument('contactType', 'mixed', 'A person or organization can have different contact points, for different purposes. For example, a sales contact point, a PR contact point and so on. This property is used to specify the kind of contact point.');
        $this->registerArgument('email', 'mixed', 'Email address.');
        $this->registerArgument('faxNumber', 'mixed', 'The fax number.');
        $this->registerArgument('hoursAvailable', 'mixed', 'The hours during which this service or contact is available.');
        $this->registerArgument('productSupported', 'mixed', 'The product or service this support contact point is related to (such as product support for a particular product line). This can be a specific product or product line (e.g. "iPhone") or a general category of products or services (e.g. "smartphones").');
        $this->registerArgument('telephone', 'mixed', 'The telephone number.');
    }
}
