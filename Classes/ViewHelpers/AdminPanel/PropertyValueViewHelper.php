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

    protected $escapeOutput = false;

    /** @var RenderingContextInterface */
    private static $localRenderingContext;

    /** @var array|null */
    private static $additionalManuals;

    /** @var IconFactory|null */
    private static $iconFactory;

    public function initializeArguments()
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
        self::$localRenderingContext = $renderingContext;

        $name = $arguments['name'];
        $value = $arguments['value'];

        if (!\is_string($value)) {
            return '';
        }

        if ($name === '@type') {
            return self::renderValue(self::buildLinksForType($value), $value);
        }

        if ($name === '@id') {
            return \htmlspecialchars($value);
        }

        if (\filter_var($value, \FILTER_VALIDATE_URL) === false || \strpos($value, 'http') !== 0) {
            return \htmlspecialchars($value);
        }

        $iconIdentifier = '';
        $linkTitle = '';

        if (\strpos($value, 'http://schema.org/') === 0 || \strpos($value, 'https://schema.org/') === 0) {
            $linkTitle = \sprintf(
                self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.openDocumentationOnSchemaOrg'),
                $value
            );
            $iconIdentifier = 'txschema-documentation-schema';
        }

        if (\in_array(\pathinfo($value, \PATHINFO_EXTENSION), self::IMAGE_EXTENSIONS)) {
            $linkTitle = self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.showImage');
            $iconIdentifier = 'actions-image';
        }

        return self::renderValue(
            [
                [
                    'link' => $value,
                    'title' => $linkTitle ?: self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.goToWebsite'),
                    'iconIdentifier' => $iconIdentifier ?: 'actions-link',
                ],
            ],
            $value
        );
    }

    private static function buildLinksForType(string $type): array
    {
        $links = [
            [
                'link' => 'https://schema.org/' . $type,
                'title' => \sprintf(
                    self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.openDocumentationOnSchemaOrg'),
                    $type
                ),
                'iconIdentifier' => 'txschema-documentation-schema',
            ],
        ];

        $additionalManuals = self::getAdditionalManuals();
        foreach ($additionalManuals[$type] ?? [] as $manual) {
            $links[] = [
                'link' => $manual['link'],
                'title' => \sprintf(self::getLanguageService()->sL($manual['title']), $type),
                'iconIdentifier' => $manual['iconIdentifier'],
            ];
        }

        return $links;
    }

    private static function getAdditionalManuals(): array
    {
        return self::$additionalManuals ?? require __DIR__ . '/../../../Configuration/TxSchema/AdditionalManuals.php';
    }

    private static function renderValue(array $links, string $value): string
    {
        $iconLinks = [];
        foreach ($links as $link) {
            $iconLinks[] = self::renderIconLink($link['link'], $link['title'], $link['iconIdentifier']);
        }

        return \trim(\implode(' ', $iconLinks) . ' ' . \htmlspecialchars($value));
    }

    private static function renderIconLink(string $link, string $title, string $iconIdentifier): string
    {
        return \sprintf(
            '<a href="%s" title="%s" target="_blank" rel="noreferrer">%s</a>',
            \htmlspecialchars($link),
            \htmlspecialchars($title),
            self::getIconFactory()->getIcon($iconIdentifier, Icon::SIZE_SMALL)->render()
        );
    }

    /**
     * @psalm-suppress MoreSpecificReturnType
     */
    private static function getIconFactory(): IconFactory
    {
        /** @psalm-suppress LessSpecificReturnStatement */
        return self::$iconFactory ?? GeneralUtility::makeInstance(IconFactory::class);
    }

    private static function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * For testing purposes only!
     * @param array $additionalManuals
     */
    public static function setAdditionalManuals(array $additionalManuals): void
    {
        self::$additionalManuals = $additionalManuals;
    }

    /**
     * For testing purposes only!
     * @param IconFactory $iconFactory
     */
    public static function setIconFactory(IconFactory $iconFactory): void
    {
        self::$iconFactory = $iconFactory;
    }
}
