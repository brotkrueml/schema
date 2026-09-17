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
 * Guide is a page or article that recommends specific products or services, or aspects of a thing for a user to consider. A Guide may represent a Buying Guide and detail aspects of products or services for a user to consider. A Guide may represent a Product Guide and recommend specific products or services. A Guide may represent a Ranked List and recommend specific products or services with ranking.
 */
final class GuideViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Guide';
}
