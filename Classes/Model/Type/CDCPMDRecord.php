<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A CDCPMDRecord is a data structure representing a record in a CDC tabular data format
 * used for hospital data reporting. See [documentation](/docs/cdc-covid.html) for details, and the linked CDC materials for authoritative
 * definitions used as the source here.
 */
#[Type('CDCPMDRecord')]
final class CDCPMDRecord extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'cvdCollectionDate',
        'cvdFacilityCounty',
        'cvdFacilityId',
        'cvdNumBeds',
        'cvdNumBedsOcc',
        'cvdNumC19Died',
        'cvdNumC19HOPats',
        'cvdNumC19HospPats',
        'cvdNumC19MechVentPats',
        'cvdNumC19OFMechVentPats',
        'cvdNumC19OverflowPats',
        'cvdNumICUBeds',
        'cvdNumICUBedsOcc',
        'cvdNumTotBeds',
        'cvdNumVent',
        'cvdNumVentUse',
        'datePosted',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
