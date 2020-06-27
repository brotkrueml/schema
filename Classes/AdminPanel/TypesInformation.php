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
    /** @var StandaloneView|null */
    private $view;

    /** @var PagesCacheService */
    private $pagesCacheService;

    /**
     * @psalm-suppress PropertyTypeCoercion
     */
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
        $jsonLd = $this->pagesCacheService->getMarkupFromCache();

        $types = [];
        if (!empty($jsonLd)) {
            $types = $this->convertJsonLdToArray($jsonLd);
            \usort($types, static function (array $a, array $b): int {
                return $a['@type'] <=> $b['@type'];
            });
        }

        $this->initialiseView();
        /** @psalm-suppress PossiblyNullReference */
        $this->view->assign('types', $types);

        return $this->view->render();
    }

    private function convertJsonLdToArray(string $jsonLd): array
    {
        $jsonLd = \str_replace(\explode('%s', Extension::JSONLD_TEMPLATE), '', $jsonLd);
        $decodedJsonLd = \json_decode($jsonLd, true);
        unset($decodedJsonLd['@context']);

        return $decodedJsonLd['@graph'] ?? [$decodedJsonLd];
    }

    private function initialiseView(): void
    {
        // The StandaloneView cannot be injected via DI in the constructor, because then the error
        // "TypoScriptFrontendController was tried to be injected before initial creation" occurs!
        if (!$this->view) {
            /** @psalm-suppress PropertyTypeCoercion */
            $this->view = GeneralUtility::makeInstance(StandaloneView::class);
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

    public function getJavaScriptFiles(): array
    {
        return [\sprintf('EXT:%s/Resources/Public/JavaScript/AdminPanel/Validate.js', Extension::KEY)];
    }

    public function getCssFiles(): array
    {
        return [];
    }

    /**
     * For testing purposes only!
     * @param StandaloneView $view
     */
    public function setView(StandaloneView $view): void
    {
        $this->view = $view;
    }
}
