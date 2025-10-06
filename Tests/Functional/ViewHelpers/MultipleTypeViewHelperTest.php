<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\ViewHelpers\MultipleTypeViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(MultipleTypeViewHelper::class)]
final class MultipleTypeViewHelperTest extends FunctionalTestCase
{
    /**
     * @var list<string>
     */
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    #[Test]
    #[DataProvider('fluidTemplatesProvider')]
    public function itBuildsSchemaCorrectly(string $template, string $expected): void
    {
        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        (new TemplateView($context))->render();

        $actual = $this->get(SchemaManager::class)->renderJsonLd();

        self::assertSame($expected, $actual);
    }

    /**
     * @return \Iterator<array<string, string>>
     */
    public static function fluidTemplatesProvider(): iterable
    {
        yield 'Using view helper without properties' => [
            'template' => '<schema:multipleType types="Product,Service"/>',
            'expected' => '{"@context":"https://schema.org/","@type":["Product","Service"]}',
        ];

        yield 'Using view helper with properties argument' => [
            'template' => <<<TEMPLATE
                <schema:multipleType
                    types="Product,Service"
                    properties="{
                        name: 'some name',
                        sku: 'some sku',
                        serviceType: 'some service type'
                    }"
                />
             TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":["Product","Service"],"name":"some name","serviceType":"some service type","sku":"some sku"}',
        ];

        yield 'Using view helper with PropertyViewHelper for properties' => [
            'template' => <<<TEMPLATE
                <schema:multipleType types="Product,Service">
                    <schema:property -as="name" value="this name"/>
                    <schema:property -as="sku" value="this sku"/>
                    <schema:property -as="serviceType" value="this service type"/>
                </schema:multipleType>',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":["Product","Service"],"name":"this name","serviceType":"this service type","sku":"this sku"}',
        ];

        yield 'Using view helper with properties argument and PropertyViewHelper for properties' => [
            'template' => <<<TEMPLATE
                <schema:multipleType types="Product,Service" properties="{name: 'that name'}">
                    <schema:property -as="sku" value="that sku"/>
                    <schema:property -as="serviceType" value="that service type"/>
                </schema:multipleType>',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":["Product","Service"],"name":"that name","serviceType":"that service type","sku":"that sku"}',
        ];

        yield 'Using view helper with id' => [
            'template' => '<schema:multipleType types="Product,Service" -id="some-id"/>',
            'expected' => '{"@context":"https://schema.org/","@type":["Product","Service"],"@id":"some-id"}',
        ];

        yield 'Using view helper as child of another type view helper' => [
            'template' => <<<TEMPLATE
                <schema:type.thing>
                    <schema:multipleType
                        types="Product,Service"
                        properties="{name: 'child name'}"
                        -as="subjectOf"
                    />
                </schema:type.thing>
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","subjectOf":{"@type":["Product","Service"],"name":"child name"}}',
        ];

        yield 'Using view helper as main entity of page' => [
            'template' => <<<TEMPLATE
                <schema:type.webPage/>
                <schema:multipleType
                    types="Product,Service"
                    properties="{name: 'child name'}"
                    -isMainEntityOfWebPage="1"
                />
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@type":"WebPage","mainEntity":{"@type":["Product","Service"],"name":"child name"}}',
        ];

        yield 'View helper inside "for" loop' => [
            'template' => <<<TEMPLATE
                <f:for each="{0: 'foo', 1: 'bar', 2: 'qux'}" as="item">
                    <schema:multipleType types="Product,Service" properties="{name: '{item}'}"/>
                </f:for>',
            TEMPLATE,
            'expected' => '{"@context":"https://schema.org/","@graph":[{"@type":["Product","Service"],"name":"foo"},{"@type":["Product","Service"],"name":"bar"},{"@type":["Product","Service"],"name":"qux"}]}',
        ];
    }

    #[Test]
    public function itThrowsExceptionWhenUsedAsAChildTypeWithoutAsArgument(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The child view helper of schema type "Product / Service" must have an "-as" argument for embedding into the parent type');

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(<<<TEMPLATE
            <schema:type.thing>
                <schema:multipleType
                    types="Product,Service"
                    properties="{name: 'child name'}"
                />
            </schema:type.thing>
        TEMPLATE);

        (new TemplateView($context))->render();
    }
}
