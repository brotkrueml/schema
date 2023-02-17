<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Lowlevel\ConfigurationModuleProvider;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Type\TypeRegistry;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\ProviderInterface;

/**
 * @internal
 */
final class Types implements ProviderInterface
{
    private string $identifier;

    public function __construct(
        private readonly TypeRegistry $typeRegistry
    ) {
    }

    public function __invoke(array $attributes): ProviderInterface
    {
        $this->identifier = $attributes['identifier'];

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getLabel(): string
    {
        return $this->translate('label');
    }

    /**
     * @return array<string, array<string|int, mixed>>
     */
    public function getConfiguration(): array
    {
        return [
            $this->translate('allTypes') => $this->getAllTypes(),
            $this->translate('webPageTypes') => $this->typeRegistry->getWebPageTypes(),
            $this->translate('webPageElementTypes') => $this->typeRegistry->getWebPageElementTypes(),
        ];
    }

    /**
     * @return array<string, list<string>>
     */
    private function getAllTypes(): array
    {
        $types = $this->typeRegistry->getTypes();
        $sortedTypes = [];
        foreach ($types as $type) {
            $type = \str_starts_with($type, '_') ? \substr($type, 1) : $type;
            $sortedTypes[substr($type, 0, 1)][] = $type;
        }
        \ksort($sortedTypes);

        return $sortedTypes;
    }

    private function translate(string $key): string
    {
        return $this->getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':lowlevel.configuration.' . $key);
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
