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
 * The act of providing goods, services, or money without compensation, often for philanthropic reasons.
 */
final class DonateActionViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'DonateAction';
}
