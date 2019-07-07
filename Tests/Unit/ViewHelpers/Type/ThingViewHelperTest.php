<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Tests\Unit\ViewHelpers\ViewHelperTestCase;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class ThingViewHelperTest extends ViewHelperTestCase
{
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

            'Type with -isMainEntityOfWebPage set to true without a WebPage' => [
                '<schema:type.thing
                    -id="parentThing"
                    -isMainEntityOfWebPage="1"
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

            'Type with -isMainEntityOfWebPage set to true with a WebPage' => [
                '<schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing"
                    -isMainEntityOfWebPage="1"
                    name="parent name"
                    url="http://example.org/">
                    <schema:type.person
                        -as="subjectOf"
                        -id="childThing"
                        name="child name"
                        url="https://example.org/child"
                    />
                </schema:type.thing>',
                '<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","mainEntity":{"@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}}</script>',
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
            'With -isMainEntityOfWebPage attribute assigned to child' => [
                '<schema:type.thing><schema:type.creativeWork -as="name" -isMainEntityOfWebPage="1"/></schema:type.thing>',
                1562517051,
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
