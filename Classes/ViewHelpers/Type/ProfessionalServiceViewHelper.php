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
 * Original definition: "provider of professional services."
 *
 * The general ProfessionalService type for local businesses was deprecated due to confusion with Service. For reference, the types that it included were: Dentist,
 * AccountingService, Attorney, Notary, as well as types for several kinds of HomeAndConstructionBusiness: Electrician, GeneralContractor,
 * HousePainter, Locksmith, Plumber, RoofingContractor. LegalService was introduced as a more inclusive supertype of Attorney.
 */
final class ProfessionalServiceViewHelper extends AbstractTypeViewHelper
{
}
