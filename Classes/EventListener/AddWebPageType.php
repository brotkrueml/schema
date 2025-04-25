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
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Page\PageInformation;

/**
 * @internal
 */
#[AsEventListener(
    identifier: 'ext-schema/addWebPageType',
)]
final readonly class AddWebPageType
{
    private const DEFAULT_WEBPAGE_TYPE = 'WebPage';

    public function __construct(
        private Configuration $configuration,
        private TypeFactory $typeFactory,
    ) {}

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        if (! $this->configuration->automaticWebPageSchemaGeneration) {
            return;
        }

        if ($event->isWebPageTypeAlreadyDefined()) {
            return;
        }

        /** @var PageInformation $pageInformation */
        $pageInformation = $event->getRequest()->getAttribute('frontend.page.information');
        $pageRecord = $pageInformation->getPageRecord();
        $webPageType = self::DEFAULT_WEBPAGE_TYPE;
        if (($pageRecord['tx_schema_webpagetype'] ?? '') !== '') {
            $webPageType = $pageRecord['tx_schema_webpagetype'];
        }
        $webPageModel = $this->typeFactory->create($webPageType);
        if ($pageRecord['endtime'] ?? 0) {
            $webPageModel->setProperty('expires', \date('c', $pageRecord['endtime']));
        }
        $event->addType($webPageModel);
    }
}
