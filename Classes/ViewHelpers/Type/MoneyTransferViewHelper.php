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
 * The act of transferring money from one place to another place. This may occur electronically or physically.
 */
final class MoneyTransferViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'MoneyTransfer';
}
