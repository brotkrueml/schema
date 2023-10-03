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
 * A FAQPage is a WebPage presenting one or more "[Frequently asked questions](https://en.wikipedia.org/wiki/FAQ)" (see also QAPage).
 */
final class FAQPageViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'FAQPage';
}
