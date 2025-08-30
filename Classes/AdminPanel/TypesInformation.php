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
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

/**
 * @internal
 */
#[Autoconfigure(public: true)]
final readonly class TypesInformation implements ModuleInterface, ContentProviderInterface, ResourceProviderInterface
{
    public function __construct(
        private MarkupCacheHandler $markupCacheHandler,
        private ViewFactoryInterface $viewFactory,
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

        $view = $this->viewFactory->create(new ViewFactoryData(
            templateRootPaths: ['EXT:' . Extension::KEY . '/Resources/Private/Templates'],
        ));
        $view->assign('types', $types);

        return $view->render('AdminPanel/TypesInformation');
    }

    /**
     * @return array<mixed>
     */
    private function convertJsonLdToArray(string $jsonLd): array
    {
        $decodedJsonLd = \json_decode($jsonLd, true, flags: \JSON_THROW_ON_ERROR);
        unset($decodedJsonLd['@context']);

        return $decodedJsonLd['@graph'] ?? [$decodedJsonLd];
    }

    /**
     * @return list<string>
     */
    public function getJavaScriptFiles(): array
    {
        $path = \sprintf('EXT:%s/Resources/Public/JavaScript/AdminPanel/', Extension::KEY);

        return [
            $path . 'Copy.js',
            $path . 'Validate.js',
        ];
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
