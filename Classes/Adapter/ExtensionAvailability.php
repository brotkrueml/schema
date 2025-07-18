<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Adapter;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * @internal
 */
readonly class ExtensionAvailability
{
    public function isSeoAvailable(): bool
    {
        return ExtensionManagementUtility::isLoaded('seo');
    }
}
