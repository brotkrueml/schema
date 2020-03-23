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
 * A profession, may involve prolonged training and/or a formal qualification.
 */
final class Occupation extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'estimatedSalary',
        'experienceRequirements',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'occupationLocation',
        'potentialAction',
        'responsibilities',
        'sameAs',
        'skills',
        'subjectOf',
        'url',
    ];
}
