<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
final class AddWebPageType
{
    private const DEFAULT_WEBPAGE_TYPE = 'WebPage';

    public function __construct(
        private readonly ExtensionConfiguration $configuration,
        private readonly TypeFactory $typeFactory,
    ) {
    }

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        $shouldGenerateWebPageSchema = $this->configuration->get(
            Extension::KEY,
            'automaticWebPageSchemaGeneration',
        );

        if (! $shouldGenerateWebPageSchema) {
            return;
        }

        if ($event->isWebPageTypeAlreadyDefined()) {
            return;
        }

        $tsfe = $this->getTypoScriptFrontendController();
        $webPageType = ($tsfe->page['tx_schema_webpagetype'] ?? '') ?: self::DEFAULT_WEBPAGE_TYPE;
        $webPageModel = $this->typeFactory->create($webPageType);
        if ($tsfe->page['endtime'] ?? 0) {
            $webPageModel->setProperty('expires', \date('c', $tsfe->page['endtime']));
        }
        $event->addType($webPageModel);
    }

    private function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
