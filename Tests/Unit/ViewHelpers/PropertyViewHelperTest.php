<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Type\TypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Parser;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class PropertyViewHelperTest extends ViewHelperTestCase
{
    use SchemaCacheTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $typeRegistryStub = $this->createStub(TypeRegistry::class);
        $map = [
            ['Thing', FixtureType\Thing::class],
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
     * Data provider for testing the property view helper in Fluid templates
     *
     * @return array
     */
    public function fluidTemplatesProvider(): iterable
    {
        yield 'Property with one value' => [
            '<schema:type.thing>
                    <schema:property -as="image" value="http://example.org/image.png"/>
                </schema:type.thing>',
            \sprintf(Extension::JSONLD_TEMPLATE, '{"@context":"https://schema.org/","@type":"Thing","image":"http://example.org/image.png"}'),
        ];

        yield 'Property with multiple values' => [
            '<schema:type.thing>
                    <schema:property -as="image" value="http://example.org/image1.png"/>
                    <schema:property -as="image" value="http://example.org/image2.png"/>
                    <schema:property -as="image" value="http://example.org/image3.png"/>
                    <schema:property -as="image" value="http://example.org/image4.png"/>
                </schema:type.thing>',
            \sprintf(Extension::JSONLD_TEMPLATE, '{"@context":"https://schema.org/","@type":"Thing","image":["http://example.org/image1.png","http://example.org/image2.png","http://example.org/image3.png","http://example.org/image4.png"]}'),
        ];

        yield 'Property with value "0"' => [
            '<schema:type.thing>
                    <schema:property -as="isAccessibleForFree" value="0"/>
                </schema:type.thing>',
            \sprintf(Extension::JSONLD_TEMPLATE, '{"@context":"https://schema.org/","@type":"Thing","isAccessibleForFree":"0"}'),
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
     * Data provider for some cases where exceptions are thrown when using the property view helper incorrectly
     *
     * @return array
     */
    public function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'View helper is not a child of a type' => [
            '<schema:property -as="someProperty" value="some value"/>',
            ViewHelper\Exception::class,
            1561838013,
        ];

        yield 'Missing -as attribute' => [
            '<schema:type.thing><schema:property value="some value"/></schema:type.thing>',
            Parser\Exception::class,
            1237823699,
        ];

        yield 'Missing value attribute' => [
            '<schema:type.thing><schema:property -as="someProperty" /></schema:type.thing>',
            Parser\Exception::class,
            1237823699,
        ];

        yield 'Empty -as attribute' => [
            '<schema:type.thing><schema:property -as="" value="some value"/></schema:type.thing>',
            ViewHelper\Exception::class,
            1561838834,
        ];

        yield 'Empty value attribute' => [
            '<schema:type.thing><schema:property -as="name" value=""/></schema:type.thing>',
            ViewHelper\Exception::class,
            1561838999,
        ];
    }

    /**
     * @test
     * @dataProvider fluidTemplatesProviderForExceptions
     *
     * @param string $template The Fluid template
     * @param string $exceptionClass The exception class
     * @param int $expectedExceptionCode The expected exception code
     */
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        string $exceptionClass,
        int $expectedExceptionCode
    ): void {
        $this->expectException($exceptionClass);
        $this->expectExceptionCode($expectedExceptionCode);

        $this->renderTemplate($template);
    }
}
