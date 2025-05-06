<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\TypoScript;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;

/**
 * Provides cObject SCHEMA.
 * This will be converted to JSON LD via TypoScriptToSchema.
 * @internal
 */
#[AutoconfigureTag(
    name: 'frontend.contentobject',
    attributes: [
        'identifier' => 'SCHEMA',
    ],
)]
final class SchemaContentObject extends AbstractContentObject
{
    /**
     * Renders the content object.
     *
     * @param array{type: string, id?: string, "properties.": array<string, mixed>} $conf
     * @phpstan-ignore-next-line parameter.defaultValue method.childParameterType
     */
    public function render($conf = []): string
    {
        $service = GeneralUtility::makeInstance(TypoScriptToSchema::class);
        $service->convert(
            $this->getContentObjectRenderer(),
            $conf,
        );

        return '';
    }
}
