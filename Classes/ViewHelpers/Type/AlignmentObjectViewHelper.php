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
 * An intangible item that describes an alignment between a learning resource and a node in an educational framework.
 *
 * Should not be used where the nature of the alignment can be described using a simple property, for example to express that a resource teaches or assesses a competency.
 */
final class AlignmentObjectViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'AlignmentObject';
}
