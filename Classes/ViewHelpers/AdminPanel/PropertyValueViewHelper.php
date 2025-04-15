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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * @internal
 */
final class PropertyValueViewHelper extends AbstractViewHelper
{
    /**
     * @var list<string>
     */
    private const IMAGE_EXTENSIONS = ['avif', 'gif', 'jpg', 'jpeg', 'png', 'webp', 'svg'];

    /**
     * @var array<string, string>
     */
    private const MANUAL_PUBLISHER_ICONS = [
        'Google' => 'ext-schema-documentation-google',
        'Yandex' => 'ext-schema-documentation-yandex',
    ];

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    private ?IconFactory $iconFactory = null;
    private ?TypeProvider $typeProvider = null;

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('name', 'string', 'Property name', true);
        $this->registerArgument('value', 'mixed', 'Property value', true);
    }

    public function render(): string
    {
        $name = $this->arguments['name'];
        $value = $this->arguments['value'];

        if (! \is_string($value)) {
            return '';
        }

        if ($name === '@type') {
            return $this->renderValue(self::buildLinksForType($value), $value);
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
            $linkTitle = 'Schema.org';
            $iconIdentifier = 'ext-schema-documentation-schema';
        }

        if (\in_array(\strtolower(\pathinfo($value, \PATHINFO_EXTENSION)), self::IMAGE_EXTENSIONS, true)) {
            $linkTitle = $this->getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.showImage');
            $iconIdentifier = 'actions-image';
        }

        return $this->renderValue(
            [
                new Link(
                    $value,
                    $linkTitle !== '' ? $linkTitle : $this->getLanguageService()->sL(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.goToWebsite'),
                    $iconIdentifier !== '' ? $iconIdentifier : 'actions-link',
                ),
            ],
            $value,
        );
    }

    /**
     * @return Link[]
     */
    private function buildLinksForType(string $type): array
    {
        $links = [$this->buildLinkForSchemaOrgType($type)];

        $manuals = $this->getTypeProvider()->getManualsForType($type);
        foreach ($manuals as $manual) {
            $links[] = new Link(
                $manual->link,
                $manual->text,
                self::MANUAL_PUBLISHER_ICONS[$manual->publisher->name],
                $manual->publisher->name,
            );
        }

        return $links;
    }

    private function buildLinkForSchemaOrgType(string $type): Link
    {
        return new Link(
            'https://schema.org/' . $type,
            'Schema.org',
            'ext-schema-documentation-schema',
        );
    }

    /**
     * @param Link[] $typeLinks
     */
    private function renderValue(array $typeLinks, string $value): string
    {
        $docLinks = [];
        foreach ($typeLinks as $typeLink) {
            $docLinks[] = $this->renderDocLink($typeLink);
        }

        return \sprintf(
            '<span class="ext-schema-adminpanel-property">%s</span> <span class="ext-schema-adminpanel-links">%s</span>',
            \htmlspecialchars($value),
            \implode(' ', $docLinks),
        );
    }

    private function renderDocLink(Link $typeLink): string
    {
        $icon = self::getIconFactory()
            ->getIcon($typeLink->iconIdentifier, Icon::SIZE_SMALL)
            ->setTitle($typeLink->alternative);

        return \sprintf(
            '<span>%s <a class="ext-schema-adminpanel-link" href="%s" target="_blank" rel="noreferrer">%s</a></span>',
            $icon->render(),
            \htmlspecialchars($typeLink->link),
            \htmlspecialchars($typeLink->title),
        );
    }

    private function getIconFactory(): IconFactory
    {
        if (! $this->iconFactory instanceof IconFactory) {
            $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        }

        return $this->iconFactory;
    }

    private function getTypeProvider(): TypeProvider
    {
        if (! $this->typeProvider instanceof TypeProvider) {
            $this->typeProvider = GeneralUtility::makeInstance(TypeProvider::class);
        }

        return $this->typeProvider;
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
