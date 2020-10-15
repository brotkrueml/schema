<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Hooks\TableConfiguration;

use Brotkrueml\Schema\Extension;
use TYPO3\CMS\Core\Database\TableConfigurationPostProcessingHookInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

final class Pages implements TableConfigurationPostProcessingHookInterface
{
    public function processData(): void
    {
        $position = 'after:description';

        if (ExtensionManagementUtility::isLoaded('seo')) {
            $position = 'after:canonical_link';
        }

        ExtensionManagementUtility::addToAllTCAtypes(
            'pages',
            '--palette--;' . Extension::LANGUAGE_PATH_DATABASE . ':pages.palette.structuredData;tx_schema_structureddata',
            '',
            $position
        );
    }
}
