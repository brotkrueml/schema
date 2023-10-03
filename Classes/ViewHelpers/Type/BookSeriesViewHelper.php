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
 * A series of books. Included books can be indicated with the hasPart property.
 */
final class BookSeriesViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'BookSeries';
}
