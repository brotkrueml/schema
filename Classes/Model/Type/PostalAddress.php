<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * The mailing address.
 */
final class PostalAddress extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'addressCountry' => null,
        'addressLocality' => null,
        'addressRegion' => null,
        'alternateName' => null,
        'areaServed' => null,
        'availableLanguage' => null,
        'contactOption' => null,
        'contactType' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'email' => null,
        'faxNumber' => null,
        'hoursAvailable' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'postOfficeBoxNumber' => null,
        'postalCode' => null,
        'potentialAction' => null,
        'productSupported' => null,
        'sameAs' => null,
        'streetAddress' => null,
        'subjectOf' => null,
        'telephone' => null,
        'url' => null,
    ];
}
