<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Provider;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Registry\TypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @deprecated Since schema version 1.7.0, will be removed in version 2.0.
 *             Use \Brotkrueml\Schema\Registry\TypeRegistry instead which is now a singleton.
 */
final class TypesProvider
{
    public function getTypes(): array
    {
        $types = GeneralUtility::makeInstance(TypeRegistry::class)->getTypes();

        $this->triggerDeprecation();

        return $types;
    }

    public function getWebPageTypes(): array
    {
        $webPageTypes = GeneralUtility::makeInstance(TypeRegistry::class)->getWebPageTypes();

        $this->triggerDeprecation();

        return $webPageTypes;
    }

    public function getWebPageElementTypes(): array
    {
        $webPageElementTypes = GeneralUtility::makeInstance(TypeRegistry::class)->getWebPageElementTypes();

        $this->triggerDeprecation();

        return $webPageElementTypes;
    }

    public function getContentTypes(): array
    {
        $contentTypes = GeneralUtility::makeInstance(TypeRegistry::class)->getContentTypes();

        $this->triggerDeprecation();

        return $contentTypes;
    }

    private function triggerDeprecation(): void
    {
        \trigger_error(
            \sprintf(
                '%s is deprecated, please use %s instead which is now a singleton.',
                static::class,
                TypeRegistry::class
            ),
            \E_USER_DEPRECATED
        );
    }
}
