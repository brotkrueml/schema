<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Frontend;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;

/**
 * Provides cObject SCHEMA.
 * This will be converted to JSON LD via TypoScriptToSchema.
 */
class SchemaContentObject extends AbstractContentObject
{
    /**
     * Renders the content object.
     *
     * @param array $configuration
     * @return string
     */
    public function render($configuration = [])
    {
        $service = GeneralUtility::makeInstance(TypoScriptToSchema::class);
        $service->convert(
            $this->cObj,
            $configuration
        );

        return '';
    }

    public static function register(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects']['SCHEMA'] = static::class;
    }
}
