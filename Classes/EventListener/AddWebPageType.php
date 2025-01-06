<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @internal
 */
final class AddWebPageType
{
    private const DEFAULT_WEBPAGE_TYPE = 'WebPage';

    public function __construct(
        private readonly Configuration $configuration,
        private readonly TypeFactory $typeFactory,
    ) {}

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        if (! $this->configuration->automaticWebPageSchemaGeneration) {
            return;
        }

        if ($event->isWebPageTypeAlreadyDefined()) {
            return;
        }

        /** @var TypoScriptFrontendController $frontendController */
        $frontendController = $event->getRequest()->getAttribute('frontend.controller');
        $webPageType = self::DEFAULT_WEBPAGE_TYPE;
        if (($frontendController->page['tx_schema_webpagetype'] ?? '') !== '') {
            $webPageType = $frontendController->page['tx_schema_webpagetype'];
        }
        $webPageModel = $this->typeFactory->create($webPageType);
        if ($frontendController->page['endtime'] ?? 0) {
            $webPageModel->setProperty('expires', \date('c', $frontendController->page['endtime']));
        }
        $event->addType($webPageModel);
    }
}
