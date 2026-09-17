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
 * A FundingScheme combines organizational, project and policy aspects of grant-based funding
 * that sets guidelines, principles and mechanisms to support other kinds of projects and activities.
 * Funding is typically organized via Grant funding. Examples of funding schemes: Swiss Priority Programmes (SPPs); EU Framework 7 (FP7); Horizon 2020; the NIH-R01 Grant Program; Wellcome institutional strategic support fund. For large scale public sector funding, the management and administration of grant awards is often handled by other, dedicated, organizations - FundingAgencys such as ERC, REA, ...
 */
final class FundingSchemeViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'FundingScheme';
}
