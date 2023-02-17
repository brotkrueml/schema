<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\AdminPanel;

use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Extension;
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
final class TypesInformation implements ModuleInterface, ContentProviderInterface, ResourceProviderInterface
{
    private readonly PagesCacheService $pagesCacheService;
    private ?StandaloneView $view = null;

    public function __construct(PagesCacheService $pagesCacheService = null)
    {
        $this->pagesCacheService = $pagesCacheService ?? GeneralUtility::makeInstance(PagesCacheService::class);
    }

    public function getIdentifier(): string
    {
        return 'ext-schema_types';
    }

    public function getLabel(): string
    {
        return $this->getLanguageService()->sL(
            Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.types'
        );
    }

    public function getContent(ModuleData $data): string
    {
        $jsonLd = $this->pagesCacheService->getMarkupFromCache() ?? '';

        $types = [];
        if ($jsonLd !== '') {
            $types = $this->convertJsonLdToArray($jsonLd);
            \usort($types, static fn (array $a, array $b): int => $a['@type'] <=> $b['@type']);
        }

        $this->initialiseView();
        $this->view->assign('types', $types);

        return $this->view->render();
    }

    /**
     * @return array<mixed>
     */
    private function convertJsonLdToArray(string $jsonLd): array
    {
        $jsonLd = \str_replace(\explode('%s', Extension::JSONLD_TEMPLATE), '', $jsonLd);
        $decodedJsonLd = \json_decode($jsonLd, true, 512, \JSON_THROW_ON_ERROR);
        unset($decodedJsonLd['@context']);

        return $decodedJsonLd['@graph'] ?? [$decodedJsonLd];
    }

    private function initialiseView(): void
    {
        // The StandaloneView cannot be injected via DI in the constructor, because then the error
        // "TypoScriptFrontendController was tried to be injected before initial creation" occurs!
        if ($this->view === null) {
            /** @var StandaloneView $view */
            $view = GeneralUtility::makeInstance(StandaloneView::class);
            $this->view = $view;
        }

        $this->view->setTemplatePathAndFilename(\sprintf(
            'EXT:%s/Resources/Private/Templates/AdminPanel/TypesInformation.html',
            Extension::KEY
        ));
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * @return string[]
     */
    public function getJavaScriptFiles(): array
    {
        return [\sprintf('EXT:%s/Resources/Public/JavaScript/AdminPanel/Validate.js', Extension::KEY)];
    }

    /**
     * @return mixed[]
     */
    public function getCssFiles(): array
    {
        return [];
    }

    /**
     * For testing purposes only!
     */
    public function setView(StandaloneView $view): void
    {
        $this->view = $view;
    }
}
