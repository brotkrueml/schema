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
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'availableLanguage',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'processingTime',
        'providesService',
        'sameAs',
        'serviceLocation',
        'servicePhone',
        'servicePostalAddress',
        'serviceSmsNumber',
        'serviceUrl',
        'subjectOf',
        'url',
    ];
}
