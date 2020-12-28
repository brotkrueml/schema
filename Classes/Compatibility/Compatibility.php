<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Compatibility;

use TYPO3\CMS\Core\Information\Typo3Version;

class Compatibility
{
    /** @var int */
    private $majorVersion;

    public function __construct()
    {
        $this->majorVersion = (new Typo3Version())->getMajorVersion();
    }

    public function hasCachePrefixForCacheIdentifier(): bool
    {
        return $this->majorVersion === 9;
    }

    public function isPsr14EventDispatcherAvailable(): bool
    {
        return $this->majorVersion > 9;
    }
}
