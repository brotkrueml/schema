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
            return self::renderLink(
                'https://schema.org/' . $value,
                self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.openDocumentationOnSchemaOrg'),
                'actions-system-extension-documentation',
                $value
            );
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
            $linkTitle = self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.openDocumentationOnSchemaOrg');
            $iconIdentifier = 'actions-system-extension-documentation';
        }

        if (\in_array(\pathinfo($value, \PATHINFO_EXTENSION), self::IMAGE_EXTENSIONS)) {
            $linkTitle = self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.showImage');
            $iconIdentifier = 'actions-image';
        }

        return self::renderLink(
            $value,
            $linkTitle ?: self::getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.info.goToWebsite'),
            $iconIdentifier ?: 'actions-link',
            $value
        );
    }

    private static function renderLink(string $link, string $title, string $iconIdentifier, string $value): string
    {
        return \sprintf(
            '<a href="%s" title="%s" target="_blank" rel="noreferrer">%s</a> %s',
            \htmlspecialchars($link),
            \htmlspecialchars($title),
            self::renderIcon($iconIdentifier),
            \htmlspecialchars($value)
        );
    }

    private static function renderIcon(string $identifier): string
    {
        /** @var IconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        return $iconFactory->getIcon($identifier, Icon::SIZE_SMALL)->render();
    }

    private static function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
