<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\Adapter\ApplicationType;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\EventDispatcher\NoopEventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;

abstract class ViewHelperTestCase extends FunctionalTestCase
{
    protected const VIEWHELPER_NAMESPACE = '{namespace schema=Brotkrueml\Schema\ViewHelpers}';

    protected bool $resetSingletonInstances = true;
    protected TemplateView $view;
    protected SchemaManager $schemaManager;

    protected function setUp(): void
    {
        $applicationType = $this->createStub(ApplicationType::class);
        $applicationType
            ->method('isBackend')
            ->willReturn(false);

        parent::setup();
        $this->view = new TemplateView();
        $this->schemaManager = new SchemaManager(
            $applicationType,
            new NoopEventDispatcher(),
            $this->createStub(ExtensionConfiguration::class),
            new Renderer(),
        );

        // This is needed for the *TypeViewHelper tests which derive from this class and use GU:makeInstance()
        GeneralUtility::setSingletonInstance(SchemaManager::class, $this->schemaManager);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    protected function renderTemplate(string $template, array $variables = []): string
    {
        $templatePath = '/tmp/ext_schema_test_template.html';

        \file_put_contents($templatePath, self::VIEWHELPER_NAMESPACE . $template);

        $this->view->getTemplatePaths()->setTemplatePathAndFilename($templatePath);

        if ($variables !== []) {
            $this->view->assignMultiple($variables);
        }

        $output = $this->view->render();

        \unlink($templatePath);

        return (string)$output;
    }
}
