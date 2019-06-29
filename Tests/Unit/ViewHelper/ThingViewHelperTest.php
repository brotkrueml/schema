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
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\Core\ViewHelper;
use TYPO3Fluid\Fluid\View\TemplateView;

class ThingViewHelperTest extends UnitTestCase
{
    protected const VIEWHELPER_NAMESPACE = '{namespace schema=Brotkrueml\Schema\ViewHelper}';

    /** @var vfsStreamDirectory */
    protected $root;

    /** @var TemplateView */
    protected $view;

    /** @var SchemaManager */
    protected $schemaManager;

    protected $resetSingletonInstances = true;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('test-dir');
        $this->view = new TemplateView();
        $this->schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
    }

    /**
     * Data provider for testing the view helpers in Fluid templates
     *
     * @return array
     */
    public function fluidTemplatesProvider(): array
    {
        return [
            'No schema view helper used' => [
                '',
                '',
            ],

            'Simple type with id' => [
                '<schema:type.thing
                    -id="thingyId"
                    name="thingy name"
                    description="thingy description"
                />',
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"}</script>',
            ],

            'Multiple types' => [
                '<schema:type.thing
                    -id="thingyId"
                    name="thingy name"
                    description="thingy description"
                />
                <schema:type.person
                    -id="personId"
                    name="person name"
                    worksFor="someone"
                />
                <schema:type.action
                    name="action name"
                    url="http://example.org/"
                />',
                '<script type="application/ld+json">[{"@context":"http://schema.org","@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"},{"@context":"http://schema.org","@type":"Person","@id":"personId","name":"person name","worksFor":"someone"},{"@context":"http://schema.org","@type":"Action","name":"action name","url":"http://example.org/"}]</script>',
            ],

            'A given specific type is recognized' => [
                '<schema:type.organization
                    name="a corporation"
                    -specificType="Corporation"
                />',
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Corporation","name":"a corporation"}</script>',
            ],

            'On top level type -as is ignored' => [
                '<schema:type.thing
                    -as="shouldBeIgnored"
                    name="as is ignored"
                />',
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","name":"as is ignored"}</script>',
            ],

            'Type with one child' => [
                '<schema:type.thing
                    -id="parentThing"
                    name="parent name"
                    url="http://example.org/">
                    <schema:type.person
                        -as="subjectOf"
                        -id="childThing"
                        name="child name"
                        url="https://example.org/child"
                    />
                </schema:type.thing>',
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}</script>',
            ],

            'Type with multiple childs' => [
                '<schema:type.organization
                    name="Acme Ltd."
                    url="https://www.example.org/"
                    logo="https://www.example.org/logo.png"
                >
                    <schema:type.contactPoint
                        -as="contactPoint"
                        telephone="+49 30 123456789"
                        contactType="sales"
                        areaServed="DE"
                    />
                    <schema:type.contactPoint
                        -as="contactPoint"
                        telephone="+48 22 123456789"
                        contactType="sales"
                        areaServed="PL"
                    />
                    <schema:type.contactPoint
                        -as="contactPoint"
                        telephone="+90 212 123456789"
                        contactType="sales"
                        areaServed="TR"
                    />
                </schema:type.organization>',
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Organization","contactPoint":[{"@type":"ContactPoint","areaServed":"DE","contactType":"sales","telephone":"+49 30 123456789"},{"@type":"ContactPoint","areaServed":"PL","contactType":"sales","telephone":"+48 22 123456789"},{"@type":"ContactPoint","areaServed":"TR","contactType":"sales","telephone":"+90 212 123456789"}],"logo":"https://www.example.org/logo.png","name":"Acme Ltd.","url":"https://www.example.org/"}</script>',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider fluidTemplatesProvider
     *
     * @param string $template The Fluid template
     * @param string $expected The expected output
     */
    public function itBuildsSchemaCorrectlyOutOfViewHelpers(string $template, string $expected): void
    {
        $this->renderTemplate($template);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame($expected, $actual);
    }

    protected function renderTemplate(string $template): void
    {
        \file_put_contents(vfsStream::url('test-dir') . '/template.html', self::VIEWHELPER_NAMESPACE . $template);

        $this->view->getTemplatePaths()->setTemplatePathAndFilename(vfsStream::url('test-dir') . '/template.html');
        $this->view->render();
    }

    /**
     * Data provider for some cases where exceptions are thrown when using the view helpers incorrectly
     *
     * @return array
     */
    public function fluidTemplatesProviderForExceptions(): array
    {
        return [
            'Invalid specific type' => [
                '<schema:type.thing -specificType="TypeDoesNotExist"/>',
                1561829970,
            ],
            'Missing -as attribute' => [
                '<schema:type.thing><schema:type.creativeWork/></schema:type.thing>',
                1561829951,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider fluidTemplatesProviderForExceptions
     *
     * @param string $template The Fluid template
     * @param int $expectedExceptionCode The expected exception code
     */
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(string $template, int $expectedExceptionCode): void
    {
        $this->expectException(ViewHelper\Exception::class);
        $this->expectExceptionCode($expectedExceptionCode);

        $this->renderTemplate($template);
    }
}
