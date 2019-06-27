<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\ViewHelper;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\Person;
use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\ViewHelper\Type\ThingViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Fluid\Unit\ViewHelpers\ViewHelperBaseTestcase;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class ThingViewHelperTest extends ViewHelperBaseTestcase
{
    /**
     * @var ThingViewHelper
     */
    protected $viewHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->viewHelper = new ThingViewHelper();
        $this->injectDependenciesIntoViewHelper($this->viewHelper);
    }

    /**
     * @test
     */
    public function renderReturnsNull(): void
    {
        $this->viewHelper->setRenderChildrenClosure(
            function () {
                return '';
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            []
        );

        $actualResult = $this->viewHelper->initializeArgumentsAndRender();

        $this->assertNull($actualResult);

        $this->resetSingletonInstances = true;
    }

    /**
     * @test
     */
    public function renderBuildsSchemaCorrectly()
    {
        $this->viewHelper->setRenderChildrenClosure(
            function () {
                return '';
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                '-id' => 'https://example.org/#test-id',
                'name' => 'test name',
            ]
        );

        $this->viewHelper->initializeArgumentsAndRender();

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $actual = $schemaManager->getTypes();

        $this->assertInstanceOf(Thing::class, $actual[0]);

        $this->assertSame('https://example.org/#test-id', $actual[0]->getId());
        $this->assertSame('test name', $actual[0]->getProperty('name'));

        $this->resetSingletonInstances = true;
    }

    /**
     * @test
     */
    public function renderWithSpecificTypeBuildsSchemaCorrectly()
    {
        $this->viewHelper->setRenderChildrenClosure(
            function () {
                return '';
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                '-specificType' => 'Person',
            ]
        );

        $this->viewHelper->initializeArgumentsAndRender();

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $actual = $schemaManager->getTypes();

        $this->assertInstanceOf(Person::class, $actual[0]);

        $this->resetSingletonInstances = true;
    }

    /**
     * @test
     */
    public function renderWithNotExistingSpecificTypeThrowsException()
    {
        $this->expectException(ViewHelper\Exception::class);
        $this->expectExceptionMessage('The given specific type "TypeNotExisting" does not exist in the schema.org vocabulary, perhaps it is misspelled?');

        $this->viewHelper->setRenderChildrenClosure(
            function () {
                return '';
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                '-specificType' => 'TypeNotExisting',
            ]
        );

        $this->viewHelper->initializeArgumentsAndRender();
    }

    /**
     * @test
     */
    public function renderIgnoresAsOnTopLevelSchema()
    {
        $this->viewHelper->setRenderChildrenClosure(
            function () {
                return '';
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                '-as' => 'propertyNameWhichIsNotShown',
                'name' => 'some name',
            ]
        );

        $this->viewHelper->initializeArgumentsAndRender();

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $actual = $schemaManager->getTypes();

        $this->assertFalse($actual[0]->hasProperty('as'));

        $this->resetSingletonInstances = true;
    }

    /**
     * @test
     */
    public function renderChildWithAlreadyExistingAsOnTheParentPreservesTheContent()
    {
        $childViewHelper = new ThingViewHelper();
        $this->injectDependenciesIntoViewHelper($childViewHelper);

        $this->setArgumentsUnderTest(
            $childViewHelper,
            [
                '-as' => 'subjectOf',
                '-id' => 'https://example.org/#child-id',
                'name' => 'child name',
                'url' => 'https://example.org/child/',
            ]
        );

        $this->viewHelper->setRenderChildrenClosure(
            function () use ($childViewHelper) {
                $childViewHelper->setRenderChildrenClosure(
                    function () {
                    }
                );

                $childViewHelper->initializeArgumentsAndRender();
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                '-id' => 'https://example.org/#parent-id',
                'name' => 'test name',
                'url' => 'https://example.org/',
            ]
        );

        $this->viewHelper->initializeArgumentsAndRender();

        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);

        $actual = $schemaManager->getTypes();

        $expected = (new Thing())
            ->setId('https://example.org/#parent-id')
            ->setProperty('name', 'test name')
            ->setProperty('url', 'https://example.org/')
            ->setProperty(
                'subjectOf',
                (new Thing())
                ->setId('https://example.org/#child-id')
                ->setProperty('name', 'child name')
                ->setProperty('url', 'https://example.org/child/')
            );

        $this->assertCount(1, $actual);
        $this->assertEquals($expected, $actual[0]);

        $this->resetSingletonInstances = true;
    }

    /**
     * @test
     */
    public function renderChildWithoutRaisesException()
    {
        $childViewHelper = new ThingViewHelper();
        $this->injectDependenciesIntoViewHelper($childViewHelper);

        $this->setArgumentsUnderTest(
            $childViewHelper,
            [
                '-id' => 'https://example.org/#child-id',
                'name' => 'child name',
                'url' => 'https://example.org/child/',
            ]
        );

        $this->viewHelper->setRenderChildrenClosure(
            function () use ($childViewHelper) {
                $childViewHelper->setRenderChildrenClosure(
                    function () {
                    }
                );

                $childViewHelper->initializeArgumentsAndRender();
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                '-id' => 'https://example.org/#test-id',
                'name' => 'test name',
                'url' => 'https://example.org/',
            ]
        );

        $this->expectException(ViewHelper\Exception::class);
        $this->expectExceptionMessage('The child view helper of schema type "Thing" must have an "-as" attribute for embedding into the parent type');

        $this->viewHelper->initializeArgumentsAndRender();

        $this->resetSingletonInstances = true;
    }
}
