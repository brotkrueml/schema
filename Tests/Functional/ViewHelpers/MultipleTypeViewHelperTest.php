<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Helper\TypeProviderWithFixturesTrait;
use Brotkrueml\Schema\Type\TypeProvider;
use Brotkrueml\Schema\ViewHelpers\MultipleTypeViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

#[CoversClass(MultipleTypeViewHelper::class)]
final class MultipleTypeViewHelperTest extends ViewHelperTestCase
{
    use SchemaCacheTrait;
    use TypeProviderWithFixturesTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineCacheStubsWhichReturnEmptyEntry();

        GeneralUtility::setSingletonInstance(TypeProvider::class, $this->getTypeProvider());
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    #[Test]
    #[DataProvider('fluidTemplatesProvider')]
    public function itBuildsSchemaCorrectly(string $template, string $expected): void
    {
        $this->renderTemplate($template, []);
        $actual = $this->schemaManager->renderJsonLd();

        self::assertSame(\sprintf(Extension::JSONLD_TEMPLATE, $expected), $actual);
    }

    public static function fluidTemplatesProvider(): iterable
    {
        yield 'Using view helper without properties' => [
            'template' => '<schema:multipleType types="ProductStub,ServiceStub"/>',
            'expected' => '{"@context":"https://schema.org/","@type":["ProductStub","ServiceStub"]}',
        ];

        yield 'Using view helper with properties argument' => [
            'template' => <<<EOF
                <schema:multipleType
                    types="ProductStub,ServiceStub"
                    properties="{
                        name: 'some name',
                        sku: 'some sku',
                        serviceType: 'some service type'
                    }"
                />
             EOF,
            'expected' => '{"@context":"https://schema.org/","@type":["ProductStub","ServiceStub"],"name":"some name","serviceType":"some service type","sku":"some sku"}',
        ];

        yield 'Using view helper with PropertyViewHelper for properties' => [
            'template' => <<<EOF
                <schema:multipleType types="ProductStub,ServiceStub">
                    <schema:property -as="name" value="this name"/>
                    <schema:property -as="sku" value="this sku"/>
                    <schema:property -as="serviceType" value="this service type"/>
                </schema:multipleType>',
            EOF,
            'expected' => '{"@context":"https://schema.org/","@type":["ProductStub","ServiceStub"],"name":"this name","serviceType":"this service type","sku":"this sku"}',
        ];

        yield 'Using view helper with properties argument and PropertyViewHelper for properties' => [
            'template' => <<<EOF
                <schema:multipleType types="ProductStub,ServiceStub" properties="{name: 'that name'}">
                    <schema:property -as="sku" value="that sku"/>
                    <schema:property -as="serviceType" value="that service type"/>
                </schema:multipleType>',
            EOF,
            'expected' => '{"@context":"https://schema.org/","@type":["ProductStub","ServiceStub"],"name":"that name","serviceType":"that service type","sku":"that sku"}',
        ];

        yield 'Using view helper with id' => [
            'template' => '<schema:multipleType types="ProductStub,ServiceStub" -id="some-id"/>',
            'expected' => '{"@context":"https://schema.org/","@type":["ProductStub","ServiceStub"],"@id":"some-id"}',
        ];

        yield 'Using view helper as child of another type view helper' => [
            'template' => <<<EOF
                <schema:type.thing>
                    <schema:multipleType
                        types="ProductStub,ServiceStub"
                        properties="{name: 'child name'}"
                        -as="subjectOf"
                    />
                </schema:type.thing>
            EOF,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","subjectOf":{"@type":["ProductStub","ServiceStub"],"name":"child name"}}',
        ];

        yield 'Using view helper as main entity of page' => [
            'template' => <<<EOF
                <schema:type.webPage/>
                <schema:multipleType
                    types="ProductStub,ServiceStub"
                    properties="{name: 'child name'}"
                    -isMainEntityOfWebPage="1"
                />
            EOF,
            'expected' => '{"@context":"https://schema.org/","@type":"WebPage","mainEntity":{"@type":["ProductStub","ServiceStub"],"name":"child name"}}',
        ];

        yield 'View helper inside "for" loop' => [
            'template' => <<<EOF
                <f:for each="{0: 'foo', 1: 'bar', 2: 'qux'}" as="item">
                    <schema:multipleType types="ProductStub,ServiceStub" properties="{name: '{item}'}"/>
                </f:for>',
            EOF,
            '{"@context":"https://schema.org/","@graph":[{"@type":["ProductStub","ServiceStub"],"name":"foo"},{"@type":["ProductStub","ServiceStub"],"name":"bar"},{"@type":["ProductStub","ServiceStub"],"name":"qux"}]}',
        ];
    }

    #[Test]
    public function itThrowsExceptionWhenUsedAsAChildTypeWithoutAsArgument(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The child view helper of schema type "ProductStub / ServiceStub" must have an "-as" argument for embedding into the parent type');

        $template = <<< EOF
            <schema:type.thing>
                <schema:multipleType
                    types="ProductStub,ServiceStub"
                    properties="{name: 'child name'}"
                />
            </schema:type.thing>
        EOF;

        $this->renderTemplate($template, []);
    }
}
