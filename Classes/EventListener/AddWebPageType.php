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

    private ExtensionConfiguration $configuration;
    private TypoScriptFrontendController $controller;

    public function __construct(
        ExtensionConfiguration $configuration,
        TypoScriptFrontendController $controller
    ) {
        $this->configuration = $configuration;
        $this->controller = $controller;
    }

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        $shouldGenerateWebPageSchema = $this->configuration->get(
            Extension::KEY,
            'automaticWebPageSchemaGeneration'
        );

        if (!$shouldGenerateWebPageSchema) {
            return;
        }

        if ($event->isWebPageTypeAlreadyDefined()) {
            return;
        }

        $webPageType = ($this->controller->page['tx_schema_webpagetype'] ?? '') ?: static::DEFAULT_WEBPAGE_TYPE;

        $webPageModel = TypeFactory::createType($webPageType);
        if ($this->controller->page['endtime'] ?? 0) {
            $webPageModel->setProperty('expires', \date('c', $this->controller->page['endtime']));
        }
        $event->addType($webPageModel);
    }
}
