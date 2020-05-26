<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers\Type;

use Brotkrueml\Schema\Model\Type;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Unit\ViewHelpers\ViewHelperTestCase;
use Brotkrueml\Schema\Type\TypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class ThingViewHelperTest extends ViewHelperTestCase
{
    use SchemaCacheTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $typeRegistryStub = $this->createStub(TypeRegistry::class);
        $map = [
            ['Action', Type\Action::class],
            ['ContactPoint', Type\ContactPoint::class],
            ['Corporation', Type\Corporation::class],
            ['CreativeWork', Type\CreativeWork::class],
            ['Event', Type\Event::class],
            ['Offer', Type\Offer::class],
            ['Organization', Type\Organization::class],
            ['Person', Type\Person::class],
            ['Thing', Type\Thing::class],
            ['WebPage', Type\WebPage::class],
        ];
        $typeRegistryStub
            ->method('resolveModelClassFromType')
            ->willReturnMap($map);

        GeneralUtility::setSingletonInstance(TypeRegistry::class, $typeRegistryStub);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        GeneralUtility::purgeInstances();
    }

    /**
     * Data provider for testing the view helpers in Fluid templates
     *
     * @return array
     */
    public function fluidTemplatesProvider(): iterable
    {
        yield 'No schema view helper used' => [
            '',
            '',
        ];

        yield 'Simple type with id' => [
            '<schema:type.thing
                    -id="thingyId"
                    name="thingy name"
                    description="thingy description"
                />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"}</script>',
        ];

        yield 'Multiple types' => [
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"},{"@type":"Person","@id":"personId","name":"person name","worksFor":"someone"},{"@type":"Action","name":"action name","url":"http://example.org/"}]}</script>',
        ];

        yield 'On top level type -as is ignored' => [
            '<schema:type.thing
                    -as="shouldBeIgnored"
                    name="as is ignored"
                />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","name":"as is ignored"}</script>',
        ];

        yield 'Type with one child' => [
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
        ];

        yield 'Type with multiple childs' => [
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
        ];

        yield 'Type inside "for" loop' => [
            '<f:for each="{0: \'foo\', 1: \'bar\', 2: \'qux\'}" as="item" iteration="iterator">
                <schema:type.thing name="{item}" identifier="{iterator.cycle}"/>
            </f:for>',
            '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"Thing","identifier":"1","name":"foo"},{"@type":"Thing","identifier":"2","name":"bar"},{"@type":"Thing","identifier":"3","name":"qux"}]}</script>',
        ];

        yield 'Type with -isMainEntityOfWebPage set to true without a WebPage' => [
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
        ];

        yield 'Type with -isMainEntityOfWebPage set to "1" with a WebPage' => [
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
        ];

        yield 'More than on type with -isMainEntityOfWebPage set to "1" with a WebPage' => [
            '<schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing#1"
                    -isMainEntityOfWebPage="1"
                    name="parent name #1"
                />
                <schema:type.thing
                    -id="parentThing#2"
                    -isMainEntityOfWebPage="1"
                    name="parent name #2"
                 />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","mainEntity":[{"@type":"Thing","@id":"parentThing#1","name":"parent name #1"},{"@type":"Thing","@id":"parentThing#2","name":"parent name #2"}]}</script>',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "true" with a WebPage' => [
            '<schema:type.webPage/>
            <schema:type.thing
                -id="parentThing"
                -isMainEntityOfWebPage="true"
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
        ];

        yield 'Type with -isMainEntityOfWebPage set to "0" with a WebPage' => [
            '<schema:type.webPage/>
            <schema:type.thing
                -id="parentThing"
                -isMainEntityOfWebPage="0"
                name="parent name"
                url="http://example.org/"
            />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"WebPage"},{"@type":"Thing","@id":"parentThing","name":"parent name","url":"http://example.org/"}]}</script>',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "false" with a WebPage' => [
            '<schema:type.webPage/>
            <schema:type.thing
                -id="parentThing"
                -isMainEntityOfWebPage="false"
                name="parent name"
                url="http://example.org/"
            />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"WebPage"},{"@type":"Thing","@id":"parentThing","name":"parent name","url":"http://example.org/"}]}</script>',
        ];

        yield 'Property value of 0.00 is rendered' => [
            '<schema:type.offer
                price="0.00"
                priceCurrency="EUR"
             />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Offer","price":"0","priceCurrency":"EUR"}</script>',
        ];

        yield 'Property value of 0.01 is rendered' => [
            '<schema:type.offer
                price="0.01"
                priceCurrency="EUR"
             />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Offer","price":"0.01","priceCurrency":"EUR"}</script>',
        ];

        yield 'Property value of "false" is rendered to http://schema.org/False' => [
            '<schema:type.event
                isAccessibleForFree="false"
             />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Event","isAccessibleForFree":"http://schema.org/False"}</script>',
        ];

        yield 'Property value of "true" is rendered to http://schema.org/True' => [
            '<schema:type.event
                isAccessibleForFree="true"
             />',
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Event","isAccessibleForFree":"http://schema.org/True"}</script>',
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

        self::assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function itRecognisesAGivenSpecificType(): void
    {
        $template = '<schema:type.organization name="a corporation" -specificType="Corporation"/>';
        $expected = '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Corporation","name":"a corporation"}</script>';

        $this->renderTemplate($template);

        $actual = $this->schemaManager->renderJsonLd();

        self::assertSame($expected, $actual);
    }

    /**
     * Data provider for some cases where exceptions are thrown when using the view helpers incorrectly
     *
     * @return array
     */
    public function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'Missing -as attribute' => [
            '<schema:type.thing><schema:type.creativeWork/></schema:type.thing>',
            1561829951,
            'The child view helper of schema type "CreativeWork" must have an "-as" argument for embedding into the parent type',
        ];

        yield 'With -isMainEntityOfWebPage attribute assigned to child' => [
            '<schema:type.thing><schema:type.creativeWork -as="name" -isMainEntityOfWebPage="1"/></schema:type.thing>',
            1562517051,
            'The argument "-isMainEntityOfWebPage" must not be used in the child type "CreativeWork", only the main type is allowed',
        ];
    }

    /**
     * @test
     * @dataProvider fluidTemplatesProviderForExceptions
     *
     * @param string $template The Fluid template
     * @param int $expectedExceptionCode The expected exception code
     * @param string $expectedExceptionMessage The expected exception message
     */
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        int $expectedExceptionCode,
        string $expectedExceptionMessage
    ): void {
        $this->expectException(ViewHelper\Exception::class);
        $this->expectExceptionCode($expectedExceptionCode);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->renderTemplate($template);
    }
}
