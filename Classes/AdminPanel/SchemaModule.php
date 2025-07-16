<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\AdminPanel;

use Brotkrueml\Schema\Cache\MarkupCacheHandler;
use Brotkrueml\Schema\Extension;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Adminpanel\ModuleApi\AbstractModule;
use TYPO3\CMS\Adminpanel\ModuleApi\ShortInfoProviderInterface;

/**
 * @internal
 */
#[Autoconfigure(public: true)]
final class SchemaModule extends AbstractModule implements ShortInfoProviderInterface
{
    public function __construct(
        private readonly MarkupCacheHandler $markupCacheHandler,
    ) {}

    public function getIconIdentifier(): string
    {
        return 'ext-schema-module-adminpanel';
    }

    public function getIdentifier(): string
    {
        return 'ext-schema';
    }

    public function getLabel(): string
    {
        return 'Schema';
    }

    public function getShortInfo(): string
    {
        $jsonLd = $this->markupCacheHandler->getMarkup() ?? '';

        $numberOfTypes = 0;
        if ($jsonLd !== '') {
            $jsonLd = \str_replace(\explode('%s', Extension::JSONLD_TEMPLATE), '', $jsonLd);
            $decodedJsonLd = \json_decode($jsonLd, true, flags: \JSON_THROW_ON_ERROR);
            $numberOfTypes = isset($decodedJsonLd['@graph']) ? \count($decodedJsonLd['@graph']) : 1;
        }

        return \sprintf(
            '(%s %s)',
            $numberOfTypes,
            $this->getLanguageService()->sL(
                Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.type' . ($numberOfTypes !== 1 ? 's' : ''),
            ),
        );
    }
}
