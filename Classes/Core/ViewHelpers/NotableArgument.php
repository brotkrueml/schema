<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\ViewHelpers;

use TYPO3\CMS\Core\Information\Typo3Version;

/**
 * Provide notable view helper arguments, which are prefixed with a dash.
 * @internal
 */
enum NotableArgument: string
{
    case As = '-as';
    case Id = '-id';
    case IsMainEntityOfWebPage = '-isMainEntityOfWebPage';

    public function type(): string
    {
        $typo3Version = (new Typo3Version())->getMajorVersion();
        $mainEntityType = $typo3Version === 13 ? 'int' : 'int|string|bool';

        return match ($this) {
            self::As => 'string',
            self::Id => 'mixed',
            self::IsMainEntityOfWebPage => $mainEntityType,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::As => 'Property name for a child node to merge under the parent node',
            self::Id => 'IRI or a node identifier to identify the node',
            self::IsMainEntityOfWebPage => 'Set to true, if the type is the primary content of the web page',
        };
    }

    public function default(): int|string
    {
        return match ($this) {
            self::As,
            self::Id => '',
            self::IsMainEntityOfWebPage => 0,
        };
    }
}
