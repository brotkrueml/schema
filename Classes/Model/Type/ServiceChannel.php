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
 * A means for accessing a service, e.g. a government office location, web site, or phone number.
 */
final class ServiceChannel extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'availableLanguage' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'processingTime' => null,
        'providesService' => null,
        'sameAs' => null,
        'serviceLocation' => null,
        'servicePhone' => null,
        'servicePostalAddress' => null,
        'serviceSmsNumber' => null,
        'serviceUrl' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
