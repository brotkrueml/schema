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
 * An individual medical practitioner. For their official address use address, for affiliations to hospitals use hospitalAffiliation.
 * The practicesAt property can be used to indicate MedicalOrganization hospitals, clinics, pharmacies etc. where this physician practices.
 */
final class IndividualPhysicianViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'IndividualPhysician';
}
