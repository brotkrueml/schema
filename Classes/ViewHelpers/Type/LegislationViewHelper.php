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
 * A legal document such as an act, decree, bill, etc. (enforceable or not) or a component of a legal act (like an article).
 */
final class LegislationViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Legislation';
}
