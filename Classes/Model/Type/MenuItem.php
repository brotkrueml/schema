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
 * A food or drink item listed in a menu or menu section.
 */
final class MenuItem extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'menuAddOn',
        'name',
        'nutrition',
        'offers',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'suitableForDiet',
        'url',
    ];
}
