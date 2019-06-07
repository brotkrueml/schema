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
 * The mailing address.
 *
 * schema.org version 3.6
 */
class PostalAddressViewHelper extends ContactPointViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('addressCountry', 'mixed', 'The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.');
        $this->registerArgument('addressLocality', 'mixed', 'The locality. For example, Mountain View.');
        $this->registerArgument('addressRegion', 'mixed', 'The region. For example, CA.');
        $this->registerArgument('postOfficeBoxNumber', 'mixed', 'The post office box number for PO box addresses.');
        $this->registerArgument('postalCode', 'mixed', 'The postal code. For example, 94043.');
        $this->registerArgument('streetAddress', 'mixed', 'The street address. For example, 1600 Amphitheatre Pkwy.');
    }
}
