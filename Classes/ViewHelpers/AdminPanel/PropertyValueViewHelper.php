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
use Brotkrueml\Schema\Manual\Link;
use Brotkrueml\Schema\Type\TypeProvider;
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
    /**
     * @var list<string>
     */
    private const IMAGE_EXTENSIONS = ['avif', 'gif', 'jpg', 'jpeg', 'png', 'webp', 'svg'];

    /**
     * @var array<string, array{title: string, iconIdentifier: string}>
     */
    private const MANUAL_PUBLISHERS = [
        'Google' => [
            'title' => Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openGoogleReference',
            'iconIdentifier' => 'ext-schema-documentation-google',
        ],
        'Yandex' => [
            'title' => Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openYandexReference',
            'iconIdentifier' => 'ext-schema-documentation-yandex',
        ],
    ];

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    private static ?IconFactory $iconFactory = null;
    private static ?TypeProvider $typeProvider = null;

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('name', 'string', 'Property name', true);
        $this->registerArgument('value', 'mixed', 'Property value', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext,
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
        if (! \str_starts_with($value, 'http')) {
            return \htmlspecialchars($value);
        }

        $iconIdentifier = '';
        $linkTitle = '';

        if (\str_starts_with($value, 'http://schema.org/') || \str_starts_with($value, 'https://schema.org/')) {
            $linkTitle = \sprintf(
                self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg'),
                $value,
            );
            $iconIdentifier = 'ext-schema-documentation-schema';
        }

        if (\in_array(\strtolower(\pathinfo($value, \PATHINFO_EXTENSION)), self::IMAGE_EXTENSIONS, true)) {
            $linkTitle = self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.showImage');
            $iconIdentifier = 'actions-image';
        }

        return self::renderValue(
            [
                new Link(
                    $value,
                    $linkTitle ?: self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.goToWebsite'),
                    $iconIdentifier ?: 'actions-link',
                ),
            ],
            $value,
        );
    }

    /**
     * @return Link[]
     */
    private static function buildLinksForType(string $type): array
    {
        $links = [self::buildLinkForSchemaOrgType($type)];

        $manuals = self::getTypeProvider()->getManualsForType($type);
        foreach ($manuals as $manual) {
            $links[] = new Link(
                $manual->link,
                \sprintf(self::getLanguageService()->sL(self::MANUAL_PUBLISHERS[$manual->publisher->name]['title']), $type),
                self::MANUAL_PUBLISHERS[$manual->publisher->name]['iconIdentifier'],
            );
        }

        return $links;
    }

    private static function buildLinkForSchemaOrgType(string $type): Link
    {
        return new Link(
            'https://schema.org/' . $type,
            \sprintf(
                self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg'),
                $type,
            ),
            'ext-schema-documentation-schema',
        );
    }

    /**
     * @param Link[] $typeLinks
     */
    private static function renderValue(array $typeLinks, string $value): string
    {
        $iconLinks = [];
        foreach ($typeLinks as $typeLink) {
            $iconLinks[] = self::renderIconLink($typeLink);
        }

        return \trim(\implode(' ', $iconLinks) . ' ' . \htmlspecialchars($value));
    }

    private static function renderIconLink(Link $typeLink): string
    {
        return \sprintf(
            '<a href="%s" title="%s" target="_blank" rel="noreferrer">%s</a>',
            \htmlspecialchars($typeLink->link),
            \htmlspecialchars($typeLink->title),
            self::getIconFactory()->getIcon($typeLink->iconIdentifier, Icon::SIZE_SMALL)->render(),
        );
    }

    private static function getIconFactory(): IconFactory
    {
        if (! self::$iconFactory instanceof \TYPO3\CMS\Core\Imaging\IconFactory) {
            self::$iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        }

        return self::$iconFactory;
    }

    private static function getTypeProvider(): TypeProvider
    {
        if (! self::$typeProvider instanceof \Brotkrueml\Schema\Type\TypeProvider) {
            self::$typeProvider = GeneralUtility::makeInstance(TypeProvider::class);
        }

        return self::$typeProvider;
    }

    private static function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * For testing purposes only!
     */
    public static function setIconFactory(IconFactory $iconFactory): void
    {
        self::$iconFactory = $iconFactory;
    }

    /**
     * For testing purposes only!
     */
    public static function setTypeProvider(TypeProvider $typeProvider): void
    {
        self::$typeProvider = $typeProvider;
    }
}
