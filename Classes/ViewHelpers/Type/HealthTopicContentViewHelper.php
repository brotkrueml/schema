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
 * HealthTopicContent is WebContent that is about some aspect of a health topic, e.g. a condition, its symptoms or treatments. Such content may be comprised of several parts or sections and use different types of media. Multiple instances of WebContent (and hence HealthTopicContent) can be related using hasPart / isPartOf where there is some kind of content hierarchy, and their content described with about and mentions e.g. building upon the existing MedicalCondition vocabulary.
 */
final class HealthTopicContentViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'HealthTopicContent';
}
