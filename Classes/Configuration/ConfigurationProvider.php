<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Configuration;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
final class ConfigurationProvider
{
    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
    ) {}

    public function getConfiguration(): Configuration
    {
        $configurationAsArray = $this->extensionConfiguration->get('schema');

        // The fallback values must be the same as in ext_conf_template.txt
        return new Configuration(
            automaticWebPageSchemaGeneration: (bool)($configurationAsArray['automaticWebPageSchemaGeneration'] ?? true),
            automaticBreadcrumbSchemaGeneration: (bool)($configurationAsArray['automaticBreadcrumbSchemaGeneration'] ?? false),
            automaticBreadcrumbExcludeAdditionalDoktypes: \array_values(
                GeneralUtility::intExplode(
                    ',',
                    $configurationAsArray['automaticBreadcrumbExcludeAdditionalDoktypes'] ?? '',
                    true,
                ),
            ),
            allowOnlyOneBreadcrumbList: (bool)($configurationAsArray['allowOnlyOneBreadcrumbList'] ?? false),
            embedMarkupInBodySection: (bool)($configurationAsArray['embedMarkupInBodySection'] ?? false),
            embedMarkupOnNoindexPages: (bool)($configurationAsArray['embedMarkupOnNoindexPages'] ?? true),
        );
    }
}
