<?php

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers;

use Brotkrueml\Schema\Manager\SchemaManager;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\View\TemplateView;

class ViewHelperTestCase extends TestCase
{
    protected const VIEWHELPER_NAMESPACE = '{namespace schema=Brotkrueml\Schema\ViewHelpers}';

    protected $resetSingletonInstances = true;

    /** @var TemplateView */
    protected $view;

    /** @var SchemaManager */
    protected $schemaManager;

    protected function setUp(): void
    {
        vfsStream::setup('test-dir');
        $this->view = new TemplateView();
        $this->schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
    }

    protected function renderTemplate(string $template, array $variables = []): string
    {
        \file_put_contents(vfsStream::url('test-dir') . '/template.html', self::VIEWHELPER_NAMESPACE . $template);

        $this->view->getTemplatePaths()->setTemplatePathAndFilename(vfsStream::url('test-dir') . '/template.html');

        if (!empty($variables)) {
            $this->view->assignMultiple($variables);
        }

        return (string)$this->view->render();
    }
}
