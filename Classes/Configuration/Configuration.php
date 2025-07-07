<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Configuration;

/**
 * Value object holding the extension configuration.
 *
 * @internal
 */
final class Configuration
{
    /**
     * @param list<int> $automaticBreadcrumbExcludeAdditionalDoktypes
     */
    public function __construct(
        public readonly bool $automaticWebPageSchemaGeneration,
        public readonly bool $automaticBreadcrumbSchemaGeneration,
        public readonly array $automaticBreadcrumbExcludeAdditionalDoktypes,
        public readonly bool $allowOnlyOneBreadcrumbList,
        public readonly bool $embedMarkupOnNoindexPages,
    ) {}
}
