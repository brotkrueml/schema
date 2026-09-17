<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A CovidTestingFacility is a MedicalClinic where testing for the COVID-19 Coronavirus
 * disease is available. If the facility is being made available from an established Pharmacy, Hotel, or other
 * non-medical organization, multiple types can be listed. This makes it easier to re-use existing schema.org information
 * about that place, e.g. contact info, address, opening hours. Note that in an emergency, such information may not always be reliable.
 */
final class CovidTestingFacilityViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'CovidTestingFacility';
}
