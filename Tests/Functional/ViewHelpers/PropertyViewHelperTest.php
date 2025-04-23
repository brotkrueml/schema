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
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\ViewHelpers\PropertyViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\Core\Parser;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(PropertyViewHelper::class)]
final class PropertyViewHelperTest extends FunctionalTestCase
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
        yield 'Property with one value' => [
            'template' => '<schema:type.thing>
                    <schema:property -as="image" value="http://example.org/image.png"/>
                </schema:type.thing>',
            'expected' => \sprintf(Extension::JSONLD_TEMPLATE, '{"@context":"https://schema.org/","@type":"Thing","image":"http://example.org/image.png"}'),
        ];

        yield 'Property with multiple values' => [
            'template' => '<schema:type.thing>
                    <schema:property -as="image" value="http://example.org/image1.png"/>
                    <schema:property -as="image" value="http://example.org/image2.png"/>
                    <schema:property -as="image" value="http://example.org/image3.png"/>
                    <schema:property -as="image" value="http://example.org/image4.png"/>
                </schema:type.thing>',
            'expected' => \sprintf(Extension::JSONLD_TEMPLATE, '{"@context":"https://schema.org/","@type":"Thing","image":["http://example.org/image1.png","http://example.org/image2.png","http://example.org/image3.png","http://example.org/image4.png"]}'),
        ];

        yield 'Property with value "0"' => [
            'template' => '<schema:type.thing>
                    <schema:property -as="description" value="0"/>
                </schema:type.thing>',
            'expected' => \sprintf(Extension::JSONLD_TEMPLATE, '{"@context":"https://schema.org/","@type":"Thing","description":"0"}'),
        ];
    }

    #[Test]
    #[DataProvider('fluidTemplatesProviderForExceptions')]
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        string $expectedExceptionClass,
        int $expectedExceptionCode,
    ): void {
        $this->expectException($expectedExceptionClass);
        $this->expectExceptionCode($expectedExceptionCode);

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);
        (new TemplateView($context))->render();
    }

    public static function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'View helper is not a child of a type' => [
            'template' => '<schema:property -as="someProperty" value="some value"/>',
            'expectedExceptionClass' => Exception::class,
            'expectedExceptionCode' => 1561838013,
        ];

        yield 'Missing -as attribute' => [
            'template' => '<schema:type.thing><schema:property value="some value"/></schema:type.thing>',
            'expectedExceptionClass' => Parser\Exception::class,
            'expectedExceptionCode' => 1237823699,
        ];

        yield 'Missing value attribute' => [
            'template' => '<schema:type.thing><schema:property -as="someProperty" /></schema:type.thing>',
            'expectedExceptionClass' => Parser\Exception::class,
            'expectedExceptionCode' => 1237823699,
        ];

        yield 'Empty -as attribute' => [
            'template' => '<schema:type.thing><schema:property -as="" value="some value"/></schema:type.thing>',
            'expectedExceptionClass' => Exception::class,
            'expectedExceptionCode' => 1561838834,
        ];

        yield 'Empty value attribute' => [
            'template' => '<schema:type.thing><schema:property -as="name" value=""/></schema:type.thing>',
            'expectedExceptionClass' => Exception::class,
            'expectedExceptionCode' => 1561838999,
        ];
    }
}
