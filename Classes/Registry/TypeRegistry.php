<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Registry;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\WebPageElementTypeInterface;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provide lists of all available types or a subset of them
 *
 * The lists of types shipped with the schema extension are
 * generated from the schema.org core definitions. Additionally,
 * more types can be registered by other extensions via
 * Configuration/TxSchema/TypeModels.php.
 *
 * @api
 */
final class TypeRegistry implements SingletonInterface
{
    private const CACHE_IDENTIFIER = 'tx_schema_core';
    private const CACHE_ENTRY_IDENTIFIER_TYPES = 'types';
    private const CACHE_ENTRY_IDENTIFIER_WEBPAGE_TYPES = 'webpage_types';
    private const CACHE_ENTRY_IDENTIFIER_WEBPAGEELEMENT_TYPES = 'webpageelement_types';

    private $types = [];
    private $webPageTypes = [];
    private $webPageElementTypes = [];

    /** @var FrontendInterface */
    private $cache;

    /** @var PackageManager */
    private $packageManager;

    public function __construct(FrontendInterface $cache = null, PackageManager $packageManager = null)
    {
        if (!$cache) {
            $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
            $this->cache = $cacheManager->getCache(static::CACHE_IDENTIFIER);
        } else {
            $this->cache = $cache;
        }

        $this->packageManager = $packageManager ?? GeneralUtility::makeInstance(PackageManager::class);
    }

    /**
     * Get all available types
     *
     * @return array<string>
     */
    public function getTypes(): array
    {
        return \array_keys($this->getTypesWithModels());
    }

    private function getTypesWithModels(): array
    {
        if (empty($this->types)) {
            $this->types = $this->loadConfiguration();
        }

        return $this->types;
    }

    private function loadConfiguration(): array
    {
        if ($this->cache->has(static::CACHE_ENTRY_IDENTIFIER_TYPES)) {
            return $this->cache->require(static::CACHE_ENTRY_IDENTIFIER_TYPES);
        }

        $packages = $this->packageManager->getActivePackages();
        $allTypeModels = [[]];
        foreach ($packages as $package) {
            $typeModelsConfiguration = $package->getPackagePath() . 'Configuration/TxSchema/TypeModels.php';
            if (\file_exists($typeModelsConfiguration)) {
                $typeModelsInPackage = require $typeModelsConfiguration;
                if (\is_array($typeModelsInPackage)) {
                    $allTypeModels[] = $this->enrichTypeModelsArrayWithTypeKey($typeModelsInPackage);
                }
            }
        }
        $typeModels = \array_replace_recursive(...$allTypeModels);
        \ksort($typeModels);

        $this->cache->set(static::CACHE_ENTRY_IDENTIFIER_TYPES, 'return ' . \var_export($typeModels, true) . ';');

        return $typeModels;
    }

    private function enrichTypeModelsArrayWithTypeKey(array $typeModels): array
    {
        $typeModelsWithTypeKey = [];
        foreach ($typeModels as $typeModel) {
            $type = \substr(\strrchr($typeModel, '\\') ?: '', 1);
            $typeModelsWithTypeKey[$type] = $typeModel;
        }

        return $typeModelsWithTypeKey;
    }

    /**
     * Get the WebPage types
     *
     * @return array<string>
     *
     * @see https://schema.org/WebPage
     */
    public function getWebPageTypes(): array
    {
        if (empty($this->webPageTypes)) {
            $this->webPageTypes = $this->loadSpecialTypes(
                static::CACHE_ENTRY_IDENTIFIER_WEBPAGE_TYPES,
                WebPageTypeInterface::class
            );
        }

        return $this->webPageTypes;
    }

    private function loadSpecialTypes(string $cacheEntryIdentifier, string $typeInterface): array
    {
        if ($this->cache->has($cacheEntryIdentifier)) {
            return $this->cache->require($cacheEntryIdentifier);
        }

        $specialTypes = [];
        foreach ($this->getTypesWithModels() as $type => $typeModel) {
            try {
                $interfaces = \array_keys((new \ReflectionClass($typeModel))->getInterfaces());

                if (\in_array($typeInterface, $interfaces)) {
                    $specialTypes[] = $type;
                }
            } catch (\ReflectionException $e) {
                // Ignore
            }
        }

        \sort($specialTypes);

        $this->cache->set($cacheEntryIdentifier, 'return ' . \var_export($specialTypes, true) . ';');

        return $specialTypes;
    }

    /**
     * Get the WebPageElement types
     *
     * @return array<string>
     *
     * @see https://schema.org/WebPageElement
     */
    public function getWebPageElementTypes(): array
    {
        if (empty($this->webPageElementTypes)) {
            $this->webPageElementTypes = $this->loadSpecialTypes(
                static::CACHE_ENTRY_IDENTIFIER_WEBPAGEELEMENT_TYPES,
                WebPageElementTypeInterface::class
            );
        }

        return $this->webPageElementTypes;
    }

    /**
     * Get the content types
     * "Content types" mean: Useful for structuring page content by an editor
     *
     * @return array<string>
     */
    public function getContentTypes(): array
    {
        return \array_values(
            \array_diff(
                $this->getTypes(),
                $this->getWebPageTypes(),
                $this->getWebPageElementTypes(),
                [
                    'BreadcrumbList',
                    'WebSite',
                ]
            )
        );
    }

    /**
     * @internal Only for internal use, not a public API!
     */
    public function resolveModelClassFromType(string $type): ?string
    {
        if (empty($type)) {
            return null;
        }

        if (empty($this->types)) {
            $this->getTypesWithModels();
        }

        if (\array_key_exists($type, $this->types)) {
            return $this->types[$type];
        }

        return null;
    }
}
