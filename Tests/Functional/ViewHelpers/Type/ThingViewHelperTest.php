<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;
use Brotkrueml\Schema\Manager\SchemaManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(AbstractTypeViewHelper::class)]
final class ThingViewHelperTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    #[Test]
    #[DataProvider('fluidTemplatesProvider')]
    public function itBuildsSchemaCorrectlyOutOfViewHelpers(string $template, string $expected): void
    {
        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        (new TemplateView($context))->render();

        $actual = $this->get(SchemaManager::class)->renderJsonLd();

        self::assertSame($expected, $actual);
    }

    public static function fluidTemplatesProvider(): iterable
    {
        yield 'Simple type with id' => [
            'template' => <<<TEMPLATE
                <schema:type.thing
                    -id="thingyId"
                    name="thingy name"
                    description="thingy description"
                />',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"}',
        ];

        yield 'Multiple types' => [
            'template' => <<<TEMPLATE
                <schema:type.thing
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
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@graph":[{"@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"},{"@type":"Person","@id":"personId","name":"person name","worksFor":"someone"},{"@type":"Action","name":"action name","url":"http://example.org/"}]}',
        ];

        yield 'On top level type -as is ignored' => [
            'template' => <<<TEMPLATE
                <schema:type.thing
                    -as="shouldBeIgnored"
                    name="as is ignored"
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","name":"as is ignored"}',
        ];

        yield 'Type with one child' => [
            'template' => <<<TEMPLATE
                <schema:type.thing
                    -id="parentThing"
                    name="parent name"
                    url="http://example.org/">
                    <schema:type.person
                        -as="subjectOf"
                        -id="childThing"
                        name="child name"
                        url="https://example.org/child"
                    />
                </schema:type.thing>
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}',
        ];

        yield 'Type with multiple childs' => [
            'template' => <<<TEMPLATE
                <schema:type.organization
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
                </schema:type.organization>
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Organization","contactPoint":[{"@type":"ContactPoint","areaServed":"DE","contactType":"sales","telephone":"+49 30 123456789"},{"@type":"ContactPoint","areaServed":"PL","contactType":"sales","telephone":"+48 22 123456789"},{"@type":"ContactPoint","areaServed":"TR","contactType":"sales","telephone":"+90 212 123456789"}],"logo":"https://www.example.org/logo.png","name":"Acme Ltd.","url":"https://www.example.org/"}',
        ];

        yield 'Type inside "for" loop' => [
            'template' => <<<TEMPLATE
                <f:for each="{0: 'foo', 1: 'bar', 2: 'qux'}" as="item" iteration="iterator">
                    <schema:type.thing name="{item}" identifier="{iterator.cycle}"/>
                </f:for>',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@graph":[{"@type":"Thing","identifier":"1","name":"foo"},{"@type":"Thing","identifier":"2","name":"bar"},{"@type":"Thing","identifier":"3","name":"qux"}]}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "false" without a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.thing
                    -id="parentThing"
                    -isMainEntityOfWebPage="false"
                    name="parent name"
                    url="http://example.org/"
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","@id":"parentThing","name":"parent name","url":"http://example.org/"}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "true" without a WebPage' => [
            'template' => <<<TEMPLATE
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
                </schema:type.thing>
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "true" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
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
                </schema:type.thing>
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"WebPage","mainEntity":{"@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "1" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
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
                </schema:type.thing>
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"WebPage","mainEntity":{"@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "2" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing"
                    -isMainEntityOfWebPage="2"
                    name="parent name"
                    url="http://example.org/">
                    <schema:type.person
                        -as="subjectOf"
                        -id="childThing"
                        name="child name"
                        url="https://example.org/child"
                    />
                </schema:type.thing>',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"WebPage","mainEntity":{"@type":"Thing","@id":"parentThing","name":"parent name","subjectOf":{"@type":"Person","@id":"childThing","name":"child name","url":"https://example.org/child"},"url":"http://example.org/"}}',
        ];

        yield 'More than on type with -isMainEntityOfWebPage set to "1" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing#1"
                    -isMainEntityOfWebPage="1"
                    name="parent name #1"
                />
                <schema:type.thing
                    -id="parentThing#2"
                    -isMainEntityOfWebPage="1"
                    name="parent name #2"
                 />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"WebPage","mainEntity":[{"@type":"Thing","@id":"parentThing#1","name":"parent name #1"},{"@type":"Thing","@id":"parentThing#2","name":"parent name #2"}]}',
        ];

        yield 'More than on type with -isMainEntityOfWebPage set, one with to "1" and one with "2" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing#1"
                    -isMainEntityOfWebPage="1"
                    name="parent name #1"
                />
                <schema:type.thing
                    -id="parentThing#2"
                    -isMainEntityOfWebPage="2"
                    name="parent name #2"
                 />',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@graph":[{"@type":"WebPage","mainEntity":{"@type":"Thing","@id":"parentThing#2","name":"parent name #2"}},{"@type":"Thing","@id":"parentThing#1","name":"parent name #1"}]}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "0" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing"
                    -isMainEntityOfWebPage="0"
                    name="parent name"
                    url="http://example.org/"
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@graph":[{"@type":"WebPage"},{"@type":"Thing","@id":"parentThing","name":"parent name","url":"http://example.org/"}]}',
        ];

        yield 'Type with -isMainEntityOfWebPage set to "false" with a WebPage' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
                <schema:type.thing
                    -id="parentThing"
                    -isMainEntityOfWebPage="false"
                    name="parent name"
                    url="http://example.org/"
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@graph":[{"@type":"WebPage"},{"@type":"Thing","@id":"parentThing","name":"parent name","url":"http://example.org/"}]}',
        ];

        yield 'Property value of 0.00 is rendered' => [
            'template' => <<<TEMPLATE
                <schema:type.offer
                    price="0.00"
                    priceCurrency="EUR"
                 />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Offer","price":"0","priceCurrency":"EUR"}',
        ];

        yield 'Property value of 0.01 is rendered' => [
            'template' => <<<TEMPLATE
                <schema:type.offer
                    price="0.01"
                    priceCurrency="EUR"
                 />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Offer","price":"0.01","priceCurrency":"EUR"}',
        ];

        yield 'Property value of "false" is rendered to https://schema.org/False' => [
            'template' => <<<TEMPLATE
                <schema:type.event
                    isAccessibleForFree="false"
                />',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Event","isAccessibleForFree":"https://schema.org/False"}',
        ];

        yield 'Property value of "true" is rendered to https://schema.org/True' => [
            'template' => <<<TEMPLATE
                <schema:type.event
                    isAccessibleForFree="true"
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Event","isAccessibleForFree":"https://schema.org/True"}',
        ];
    }

    #[Test]
    public function itRecognisesAGivenSpecificType(): void
    {
        $template = '<schema:type.organization name="a corporation" -specificType="Corporation"/>';
        $expected = '{"@context":"https://schema.org/","@type":"Corporation","name":"a corporation"}';

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        (new TemplateView($context))->render();

        $actual = $this->get(SchemaManager::class)->renderJsonLd();

        self::assertSame($expected, $actual);
    }

    /**
     * @param string $template The Fluid template
     * @param int $expectedExceptionCode The expected exception code
     * @param string $expectedExceptionMessage The expected exception message
     */
    #[Test]
    #[DataProvider('fluidTemplatesProviderForExceptions')]
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        int $expectedExceptionCode,
        string $expectedExceptionMessage,
    ): void {
        $this->expectException(Exception::class);
        $this->expectExceptionCode($expectedExceptionCode);
        $this->expectExceptionMessage($expectedExceptionMessage);

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        (new TemplateView($context))->render();
    }

    public static function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'Missing -as attribute' => [
            'template' => '<schema:type.thing><schema:type.creativeWork/></schema:type.thing>',
            'expectedExceptionCode' => 1561829951,
            'expectedExceptionMessage' => 'The child view helper of schema type "CreativeWork" must have an "-as" argument for embedding into the parent type',
        ];

        yield 'With -isMainEntityOfWebPage attribute assigned to child' => [
            'template' => '<schema:type.thing><schema:type.creativeWork -as="name" -isMainEntityOfWebPage="1"/></schema:type.thing>',
            'expectedExceptionCode' => 1562517051,
            'expectedExceptionMessage' => 'The argument "-isMainEntityOfWebPage" must not be used in the child type "CreativeWork", only the main type is allowed',
        ];

        yield 'With -isMainEntityOfWebPage is set to a negative value' => [
            'template' => '<schema:type.thing><schema:type.creativeWork -as="name" -isMainEntityOfWebPage="-1"/></schema:type.thing>',
            'expectedExceptionCode' => 1636570950,
            'expectedExceptionMessage' => 'The value of argument "-isMainEntityOfWebPage" must be between 0 and 2, "-1" given (allowed: 0 = not a main entity, 1 = main entity, 2 = prioritised main entity',
        ];

        yield 'With -isMainEntityOfWebPage is set to a value greater 2' => [
            'template' => '<schema:type.thing><schema:type.creativeWork -as="name" -isMainEntityOfWebPage="3"/></schema:type.thing>',
            'expectedExceptionCode' => 1636570950,
            'expectedExceptionMessage' => 'The value of argument "-isMainEntityOfWebPage" must be between 0 and 2, "3" given (allowed: 0 = not a main entity, 1 = main entity, 2 = prioritised main entity',
        ];
    }
}
