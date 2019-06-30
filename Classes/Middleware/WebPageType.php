<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Middleware;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class WebPageType implements MiddlewareInterface
{
    /** @var TypoScriptFrontendController */
    private $controller;

    /** @var SchemaManager */
    private $schemaManager;

    /** @var ExtensionConfiguration */
    private $configuration;

    public function __construct(TypoScriptFrontendController $controller = null, SchemaManager $schemaManager = null, ExtensionConfiguration $configuration = null)
    {
        $this->controller = $controller ?: $GLOBALS['TSFE'];
        $this->schemaManager = $schemaManager ?: GeneralUtility::makeInstance(SchemaManager::class);
        $this->configuration = $configuration ?: GeneralUtility::makeInstance(ExtensionConfiguration::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $shouldGenerateWebPageSchema = $this->configuration->get('schema', 'automaticWebPageSchemaGeneration');

        if (!$shouldGenerateWebPageSchema) {
            return $handler->handle($request);
        }

        if ($this->schemaManager->hasWebPage()) {
            return $handler->handle($request);
        }

        $type = $this->controller->page['tx_schema_webpagetype'] ?: 'WebPage';

        $webPageClass = 'Brotkrueml\\Schema\\Model\\Type\\' . $type;

        if (\class_exists($webPageClass)) {
            /** @var AbstractType $webPage */
            $webPage = GeneralUtility::makeInstance($webPageClass);
            $webPage->setProperty('name', $this->controller->page['title']);

            if ($this->controller->page['description']) {
                $webPage->setProperty('description', $this->controller->page['description']);
            }

            if ($this->controller->page['endtime']) {
                $webPage->setProperty('expires', \date('c', $this->controller->page['endtime']));
            }

            $this->schemaManager->addType($webPage);
        }

        return $handler->handle($request);
    }
}
