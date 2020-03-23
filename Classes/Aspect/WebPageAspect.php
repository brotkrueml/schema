<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Aspect;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Registry\TypeRegistry;
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

    /** @var TypeRegistry */
    private $typeRegistry;

    public function __construct(
        TypoScriptFrontendController $controller = null,
        ExtensionConfiguration $configuration = null,
        TypeRegistry $typeRegistry = null
    ) {
        $this->controller = $controller ?? $GLOBALS['TSFE'];
        $this->configuration = $configuration ?? GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->typeRegistry = $typeRegistry ?? new TypeRegistry();
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

        $type = $this->controller->page['tx_schema_webpagetype'] ?: static::DEFAULT_WEBPAGE_TYPE;

        $webPageClass = $this->typeRegistry->resolveModelClassFromType($type);
        if ($webPageClass) {
            /** @var AbstractType $webPage */
            $webPage = new $webPageClass();

            if ($this->controller->page['endtime']) {
                $webPage->setProperty('expires', \date('c', $this->controller->page['endtime']));
            }

            $schemaManager->addType($webPage);
        }
    }
}
