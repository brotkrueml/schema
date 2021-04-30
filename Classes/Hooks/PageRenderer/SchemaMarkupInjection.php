<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Hooks\PageRenderer;

use Brotkrueml\Schema\Aspect\AspectInterface;
use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use Brotkrueml\Schema\Manager\SchemaManager;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class SchemaMarkupInjection
{
    private ApplicationType $applicationType;
    private TypoScriptFrontendController $controller;

    /** @var array<string, mixed> */
    private array $configuration;

    private SchemaManager $schemaManager;
    private EventDispatcher $eventDispatcher;
    private PagesCacheService $pagesCacheService;

    /** @psalm-suppress PropertyTypeCoercion */
    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $extensionConfiguration = null,
        SchemaManager $schemaManager = null,
        PagesCacheService $pagesCacheService = null,
        EventDispatcher $eventDispatcher = null,
        ApplicationType $applicationType = null
    ) {
        $this->applicationType = $applicationType ?? ApplicationType::fromRequest($this->getRequest());
        if ($this->applicationType->isBackend()) {
            return;
        }
        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $extensionConfiguration ??= GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->configuration = $extensionConfiguration->get('schema') ?? [];
        $this->schemaManager = $schemaManager ?? GeneralUtility::makeInstance(SchemaManager::class);
        $this->pagesCacheService = $pagesCacheService ?? GeneralUtility::makeInstance(PagesCacheService::class);
        $this->eventDispatcher =
            $eventDispatcher instanceof EventDispatcher
                ? $eventDispatcher
                : GeneralUtility::makeInstance(EventDispatcher::class);
    }

    public function execute(?array &$params, PageRenderer &$pageRenderer): void
    {
        if ($this->applicationType->isBackend()) {
            return;
        }

        if (!$this->shouldEmbedMarkup()) {
            return;
        }

        $result = $this->pagesCacheService->getMarkupFromCache();
        if ($result === null) {
            foreach ($this->getRegisteredAspects() as $aspect) {
                $aspect->execute($this->schemaManager);
            }

            if (($result = $this->schemaManager->renderJsonLd()) !== '') {
                $this->pagesCacheService->storeMarkupInCache($result);
            }
        }

        if ($result === '') {
            return;
        }

        if ($this->configuration['embedMarkupInBodySection'] ?? false) {
            $pageRenderer->addFooterData($result);
        } else {
            $pageRenderer->addHeaderData($result);
        }
    }

    private function shouldEmbedMarkup(): bool
    {
        /** @psalm-suppress PossiblyNullPropertyFetch, PossiblyNullArgument */
        $event = new ShouldEmbedMarkupEvent($this->controller->page, true);
        $event = $this->eventDispatcher->dispatch($event);

        return $event->getEmbedMarkup();
    }

    private function getRegisteredAspects(): array
    {
        $aspects = [];
        // This hook is only for internal use and will be transformed to PSR-14 event
        // when TYPO3 v10 is a minimum requirement
        foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/schema']['registerAspect'] ?? [] as $aspect) {
            $aspectInstance = new $aspect();
            if (!$aspectInstance instanceof AspectInterface) {
                throw new \InvalidArgumentException(
                    \sprintf(
                        'Aspect "%s" must implement interface "%s"',
                        $aspect,
                        AspectInterface::class
                    ),
                    1583429697
                );
            }

            $aspects[] = $aspectInstance;
        }

        return $aspects;
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
