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
 * Recommendation is a type of Review that suggests or proposes something as the best option or best course of action. Recommendations may be for products or services, or other concrete things, as in the case of a ranked list or product guide. A Guide may list multiple recommendations for different categories. For example, in a Guide about which TVs to buy, the author may have several Recommendations.
 */
final class RecommendationViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'Recommendation';
}
