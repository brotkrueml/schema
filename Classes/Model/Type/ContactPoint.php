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
 * A contact point&amp;#x2014;for example, a Customer Complaints department.
 */
final class ContactPoint extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
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
        'potentialAction' => null,
        'productSupported' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'telephone' => null,
        'url' => null,
    ];
}
