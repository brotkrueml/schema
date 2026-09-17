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
 * A FundingAgency is an organization that implements one or more FundingSchemes and manages
 * the granting process (via Grants, typically MonetaryGrants).
 * A funding agency is not always required for grant funding, e.g. philanthropic giving, corporate sponsorship etc.
 *
 * Examples of funding agencies include ERC, REA, NIH, Bill and Melinda Gates Foundation, ...
 */
final class FundingAgencyViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'FundingAgency';
}
