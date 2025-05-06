<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\TypoScript;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Manager\SchemaManager;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
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
    public function __construct(
        private readonly TypeBuilder $typeBuilder,
        private readonly PropertiesAdder $propertiesAdder,
        private readonly SchemaManager $schemaManager,
    ) {}

    /**
     * Renders the content object.
     *
     * @param array{type: string, id?: string, "properties.": array<string, mixed>} $conf
     * @phpstan-ignore-next-line parameter.defaultValue method.childParameterType
     */
    public function render($conf = []): string
    {
        $type = $this->typeBuilder->build($this->getContentObjectRenderer(), $conf);
        if ($type instanceof TypeInterface) {
            $this->propertiesAdder->add($this->getContentObjectRenderer(), $type, $conf['properties.'] ?? []);
            $this->schemaManager->addType($type);
        }

        return '';
    }
}
