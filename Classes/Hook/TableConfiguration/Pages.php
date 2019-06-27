<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Hook\TableConfiguration;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Database\TableConfigurationPostProcessingHookInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class Pages implements TableConfigurationPostProcessingHookInterface
{
    public function processData(): void
    {
        $position = 'after:description';

        if (ExtensionManagementUtility::isLoaded('seo')) {
            $position = 'after:canonical_link';
        }

        ExtensionManagementUtility::addToAllTCAtypes(
            'pages',
            '--palette--;LLL:EXT:schema/Resources/Private/Language/locallang_db.xlf:pages.palette.structuredData;tx_schema_structureddata',
            '',
            $position
        );
    }
}
