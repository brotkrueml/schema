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
 * An Article whose content is primarily satirical(https://en.wikipedia.org/wiki/Satire) in nature, i.e. unlikely to be literally true. A satirical article is sometimes but not necessarily also a NewsArticle. ScholarlyArticles are also sometimes satirized.
 */
final class SatiricalArticleViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'SatiricalArticle';
}
