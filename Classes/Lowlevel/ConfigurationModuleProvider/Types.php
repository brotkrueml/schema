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
use Brotkrueml\Schema\Type\TypeProvider;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Lowlevel\ConfigurationModuleProvider\ProviderInterface;

/**
 * @internal
 */
final class Types implements ProviderInterface
{
    private string $identifier;

    public function __construct(
        private readonly TypeProvider $typeProvider,
    ) {}

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
        $webPageTypes = $this->typeProvider->getWebPageTypes();
        \sort($webPageTypes);

        return [
            $this->translate('allTypes') => $this->getAllTypes(),
            $this->translate('webPageTypes') => $webPageTypes,
        ];
    }

    /**
     * @return array<string, list<string>>
     */
    private function getAllTypes(): array
    {
        $types = $this->typeProvider->getTypes();
        \usort($types, static fn(string $a, string $b): int => \strtolower($a) <=> \strtolower($b));
        $sortedTypes = [];
        foreach ($types as $type) {
            $sortedTypes[\substr($type, 0, 1)][] = $type;
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
