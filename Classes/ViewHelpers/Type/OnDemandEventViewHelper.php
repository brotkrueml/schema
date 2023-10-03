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
 * A publication event, e.g. catch-up TV or radio podcast, during which a program is available on-demand.
 */
final class OnDemandEventViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'OnDemandEvent';
}
