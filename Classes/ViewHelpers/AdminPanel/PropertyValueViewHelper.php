<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\AdminPanel;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Model\Manual\TypeLink;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper;

/**
 * @internal
 */
final class PropertyValueViewHelper extends ViewHelper\AbstractViewHelper
{
    private const IMAGE_EXTENSIONS = ['gif', 'jpg', 'jpeg', 'png', 'svg'];

    private const MANUAL_PROVIDERS = [
        'google' => [
            'title' => Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openGoogleReference',
            'iconIdentifier' => 'ext-schema-documentation-google',
        ],
        'yandex' => [
            'title' => Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openYandexReference',
            'iconIdentifier' => 'ext-schema-documentation-yandex',
        ],
    ];

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var TypeLink[]|null
     */
    private static ?array $additionalManuals = null;

    private static ?IconFactory $iconFactory = null;

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('name', 'string', 'Property name', true);
        $this->registerArgument('value', 'mixed', 'Property value', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        $name = $arguments['name'];
        $value = $arguments['value'];

        if (! \is_string($value)) {
            return '';
        }

        if ($name === '@type') {
            return self::renderValue(self::buildLinksForType($value), $value);
        }

        if ($name === '@id') {
            return \htmlspecialchars($value);
        }
        if (\filter_var($value, \FILTER_VALIDATE_URL) === false) {
            return \htmlspecialchars($value);
        }
        if (! str_starts_with($value, 'http')) {
            return \htmlspecialchars($value);
        }

        $iconIdentifier = '';
        $linkTitle = '';

        if (\str_starts_with($value, 'http://schema.org/') || \str_starts_with($value, 'https://schema.org/')) {
            $linkTitle = \sprintf(
                self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg'),
                $value
            );
            $iconIdentifier = 'ext-schema-documentation-schema';
        }

        if (\in_array(\strtolower(\pathinfo($value, \PATHINFO_EXTENSION)), self::IMAGE_EXTENSIONS, true)) {
            $linkTitle = self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.showImage');
            $iconIdentifier = 'actions-image';
        }

        return self::renderValue(
            [
                new TypeLink(
                    $value,
                    $linkTitle ?: self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.goToWebsite'),
                    $iconIdentifier ?: 'actions-link'
                ),
            ],
            $value
        );
    }

    /**
     * @return TypeLink[]
     */
    private static function buildLinksForType(string $type): array
    {
        $links = [self::buildLinkForSchemaOrgType($type)];

        $additionalManuals = self::getAdditionalManuals();
        $manualType = $additionalManuals[$type]['like'] ?? $type;
        foreach ($additionalManuals[$manualType] ?? [] as $manual) {
            $provider = $manual['provider'] ?? '';
            if (! $provider) {
                continue;
            }
            if (! \array_key_exists($provider, self::MANUAL_PROVIDERS)) {
                continue;
            }

            $links[] = new TypeLink(
                $manual['link'],
                \sprintf(self::getLanguageService()->sL(self::MANUAL_PROVIDERS[$provider]['title']), $manualType),
                self::MANUAL_PROVIDERS[$provider]['iconIdentifier']
            );
        }

        return $links;
    }

    private static function buildLinkForSchemaOrgType(string $type): TypeLink
    {
        return new TypeLink(
            'https://schema.org/' . $type,
            \sprintf(
                self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg'),
                $type
            ),
            'ext-schema-documentation-schema'
        );
    }

    /**
     * @return array<string, mixed>
     */
    private static function getAdditionalManuals(): array
    {
        return self::$additionalManuals ?? require __DIR__ . '/../../../Configuration/TxSchema/AdditionalManuals.php';
    }

    /**
     * @param TypeLink[] $typeLinks
     */
    private static function renderValue(array $typeLinks, string $value): string
    {
        $iconLinks = [];
        foreach ($typeLinks as $typeLink) {
            $iconLinks[] = self::renderIconLink($typeLink);
        }

        return \trim(\implode(' ', $iconLinks) . ' ' . \htmlspecialchars($value));
    }

    private static function renderIconLink(TypeLink $typeLink): string
    {
        return \sprintf(
            '<a href="%s" title="%s" target="_blank" rel="noreferrer">%s</a>',
            \htmlspecialchars($typeLink->getLink()),
            \htmlspecialchars($typeLink->getTitle()),
            self::getIconFactory()->getIcon($typeLink->getIconIdentifier(), Icon::SIZE_SMALL)->render()
        );
    }

    private static function getIconFactory(): IconFactory
    {
        return self::$iconFactory ?? GeneralUtility::makeInstance(IconFactory::class);
    }

    private static function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * For testing purposes only!
     * @param array<string, mixed> $additionalManuals
     */
    public static function setAdditionalManuals(array $additionalManuals): void
    {
        self::$additionalManuals = $additionalManuals;
    }

    /**
     * For testing purposes only!
     */
    public static function setIconFactory(IconFactory $iconFactory): void
    {
        self::$iconFactory = $iconFactory;
    }
}
