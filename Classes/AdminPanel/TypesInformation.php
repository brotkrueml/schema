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
use TYPO3\CMS\Adminpanel\ModuleApi\ContentProviderInterface;
use TYPO3\CMS\Adminpanel\ModuleApi\ModuleData;
use TYPO3\CMS\Adminpanel\ModuleApi\ModuleInterface;
use TYPO3\CMS\Adminpanel\ModuleApi\ResourceProviderInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * @internal
 */
#[Autoconfigure(public: true)]
final readonly class TypesInformation implements ModuleInterface, ContentProviderInterface, ResourceProviderInterface
{
    public function __construct(
        private MarkupCacheHandler $markupCacheHandler,
    ) {}

    public function getIdentifier(): string
    {
        return 'ext-schema_types';
    }

    public function getLabel(): string
    {
        return $this->getLanguageService()->sL(
            Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.types',
        );
    }

    public function getContent(ModuleData $data): string
    {
        $jsonLd = $this->markupCacheHandler->getMarkup() ?? '';

        $types = [];
        if ($jsonLd !== '') {
            $types = $this->convertJsonLdToArray($jsonLd);
            \usort($types, static fn(array $a, array $b): int => $a['@type'] <=> $b['@type']);
        }

        $view = $this->initialiseView();
        $view->assign('types', $types);

        return $view->render();
    }

    /**
     * @return array<mixed>
     */
    private function convertJsonLdToArray(string $jsonLd): array
    {
        $jsonLd = \str_replace(\explode('%s', Extension::JSONLD_TEMPLATE), '', $jsonLd);
        $decodedJsonLd = \json_decode($jsonLd, true, flags: \JSON_THROW_ON_ERROR);
        unset($decodedJsonLd['@context']);

        return $decodedJsonLd['@graph'] ?? [$decodedJsonLd];
    }

    private function initialiseView(): StandaloneView
    {
        /** @var StandaloneView $view */
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(
            'EXT:' . Extension::KEY . '/Resources/Private/Templates/AdminPanel/TypesInformation.html',
        );

        return $view;
    }

    /**
     * @return list<string>
     */
    public function getJavaScriptFiles(): array
    {
        return [\sprintf('EXT:%s/Resources/Public/JavaScript/AdminPanel/Validate.js', Extension::KEY)];
    }

    /**
     * @return array{}
     */
    public function getCssFiles(): array
    {
        return [];
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
