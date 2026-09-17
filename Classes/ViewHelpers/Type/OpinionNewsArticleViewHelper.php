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
 * An OpinionNewsArticle is a NewsArticle that primarily expresses opinions rather than journalistic reporting of news and events. For example, a NewsArticle consisting of a column or Blog/BlogPosting entry in the Opinions section of a news publication.
 */
final class OpinionNewsArticleViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'OpinionNewsArticle';
}
