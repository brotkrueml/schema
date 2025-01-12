<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\TypoScript;

/**
 * Copied and adapted from \TYPO3\CMS\Core\TypoScriptService::convertTypoScriptArrayToPlainArray()
 * as the methods are marked as internal.
 */
final class TypoScriptConverter
{
    /**
     * @param array<mixed> $typoScriptArray
     * @return array<mixed>
     */
    public function convertTypoScriptArrayToPlainArray(array $typoScriptArray): array
    {
        foreach ($typoScriptArray as $key => $value) {
            if (! \str_ends_with((string) $key, '.')) {
                continue;
            }

            $keyWithoutDot = \substr((string) $key, 0, -1);
            $typoScriptNodeValue = $typoScriptArray[$keyWithoutDot] ?? null;
            if (\is_array($value)) {
                $typoScriptArray[$keyWithoutDot] = $this->convertTypoScriptArrayToPlainArray($value);
                if ($typoScriptNodeValue !== null) {
                    $typoScriptArray[$keyWithoutDot]['_typoScriptNodeValue'] = $typoScriptNodeValue;
                }
                unset($typoScriptArray[$key]);
                continue;
            }

            $typoScriptArray[$keyWithoutDot] = null;
        }

        return $typoScriptArray;
    }

    /**
     * @param array<mixed> $plainArray
     * @return array<mixed>
     */
    public function convertPlainArrayToTypoScriptArray(array $plainArray): array
    {
        $typoScriptArray = [];
        foreach ($plainArray as $key => $value) {
            if (\is_array($value)) {
                if (isset($value['_typoScriptNodeValue'])) {
                    $typoScriptArray[$key] = $value['_typoScriptNodeValue'];
                    unset($value['_typoScriptNodeValue']);
                }
                $typoScriptArray[$key . '.'] = $this->convertPlainArrayToTypoScriptArray($value);
                continue;
            }

            $typoScriptArray[$key] = $value ?? '';
        }

        return $typoScriptArray;
    }
}
