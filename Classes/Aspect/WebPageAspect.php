<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Aspect;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class WebPageAspect implements AspectInterface
{
    private const DEFAULT_WEBPAGE_TYPE = 'WebPage';

    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var ExtensionConfiguration */
    private $configuration;

    /** @psalm-suppress PropertyTypeCoercion */
    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $configuration = null
    ) {
        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $this->configuration = $configuration ?? GeneralUtility::makeInstance(ExtensionConfiguration::class);
    }

    public function execute(SchemaManager $schemaManager): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $shouldGenerateWebPageSchema = $this->configuration->get('schema', 'automaticWebPageSchemaGeneration');

        if (!$shouldGenerateWebPageSchema) {
            return;
        }

        if ($schemaManager->hasWebPage()) {
            return;
        }

        $webPageType = ($this->controller->page['tx_schema_webpagetype'] ?? '') ?: static::DEFAULT_WEBPAGE_TYPE;
        try {
            $webPageModel = TypeFactory::createType($webPageType);
            if ($this->controller->page['endtime']) {
                $webPageModel->setProperty('expires', \date('c', $this->controller->page['endtime']));
            }

            $schemaManager->addType($webPageModel);
        } catch (\DomainException $e) {
            // Do nothing
        }
    }
}
