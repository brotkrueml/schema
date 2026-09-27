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
use Brotkrueml\Schema\ViewHelpers\OrderedListViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\Core\Parser;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(OrderedListViewHelper::class)]
#[RunTestsInSeparateProcesses]
final class OrderedListViewHelperTest extends FunctionalTestCase
{
    protected bool $initializeDatabase = false;

    /**
     * @var list<string>
     */
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    #[Test]
    #[DataProvider('fluidTemplatesProvider')]
    public function itBuildsSchemaCorrectlyOutOfViewHelpers(string $template, string $expected): void
    {
        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()
            ->setTemplateSource($template);
        (new TemplateView($context))->render();

        $actual = $this->get(SchemaManager::class)->renderJsonLd();

        self::assertSame($expected, $actual);
    }

    /**
     * @return \Iterator<array<string, string>>
     */
    public static function fluidTemplatesProvider(): iterable
    {
        yield 'Items with string values' => [
            'template' => <<<TEMPLATE
                <schema:type.thing>
                    <schema:orderedList -as="sameAs" items="{0: 'foo', 1: 'bar'}"/>
                </schema:type.thing>
            TEMPLATE
            ,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","sameAs":{"@list":["foo","bar"]}}',
        ];

        yield 'Items with node identifiers' => [
            'template' => <<<TEMPLATE
                <schema:type.thing>
                    <schema:orderedList -as="sameAs" items="{
                        0: '{schema:nodeIdentifier(id: \\'https://example.org/#some-item\\')}',
                        1: '{schema:nodeIdentifier(id: \\'https://example.org/#another-item\\')}'
                    }"/>
                </schema:type.thing>
            TEMPLATE
            ,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","sameAs":{"@list":[{"@id":"https://example.org/#some-item"},{"@id":"https://example.org/#another-item"}]}}',
        ];

        yield 'Items with blank node identifiers' => [
            'template' => <<<TEMPLATE
                <schema:type.thing>
                    <schema:orderedList -as="sameAs" items="{
                        0: '{schema:blankNodeIdentifier()}',
                        1: '{schema:blankNodeIdentifier()}'
                    }"/>
                </schema:type.thing>
            TEMPLATE
            ,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","sameAs":{"@list":[{"@id":"_:b0"},{"@id":"_:b1"}]}}',
        ];

        yield 'Items collected in a loop' => [
            'template' => <<<TEMPLATE
                <f:variable name="orderedList" value="{null}"/>
                <f:for each="{0: 1, 1: 2}" as="value" reverse="1">
                    <f:variable name="thing"><schema:nodeIdentifier id="https://example.org/#thing-{value}"/></f:variable>
                    <f:variable name="orderedList"><f:merge array="{0: '{schema:nodeIdentifier(id: \\'https://example.org/#thing-{value}\\')}'}" with="{orderedList}"/></f:variable>
                </f:for>

                <schema:type.thing name="with ordered list">
                    <schema:orderedList -as="sameAs" items="{orderedList}"/>
                </schema:type.thing>
            TEMPLATE
            ,
            'expected' => '{"@context":"https://schema.org/","@type":"Thing","name":"with ordered list","sameAs":{"@list":[{"@id":"https://example.org/#thing-1"},{"@id":"https://example.org/#thing-2"}]}}',
        ];
    }

    #[Test]
    #[DataProvider('fluidTemplatesProviderForExceptions')]
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        string $expectedExceptionClass,
    ): void {
        $this->expectException($expectedExceptionClass);

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()
            ->setTemplateSource($template);
        (new TemplateView($context))->render();
    }

    /**
     * @return \Iterator<array<array<string, mixed>, mixed>>
     */
    public static function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'Missing -as attribute' => [
            'template' => '<schema:type.thing><schema:orderedList items="{0: \'foo\'}"/></schema:type.thing>',
            'expectedExceptionClass' => Parser\Exception::class,
        ];

        yield 'Missing items attribute' => [
            'template' => '<schema:type.thing><schema:orderedList -as="someProperty"/></schema:type.thing>',
            'expectedExceptionClass' => Parser\Exception::class,
        ];

        yield 'Empty -as attribute' => [
            'template' => '<schema:type.thing><schema:orderedList -as="" items="{0: \'foo\'}"/></schema:type.thing>',
            'expectedExceptionClass' => Exception::class,
        ];

        yield 'Empty items attribute' => [
            'template' => '<schema:type.thing><schema:orderedList -as="name" items=""/></schema:type.thing>',
            'expectedExceptionClass' => Exception::class,
        ];
    }
}
