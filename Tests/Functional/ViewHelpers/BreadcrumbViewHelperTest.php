<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\Core\Exception\MissingBreadcrumbArgumentException;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\ViewHelpers\BreadcrumbViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\Core\Parser\Exception;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(BreadcrumbViewHelper::class)]
final class BreadcrumbViewHelperTest extends FunctionalTestCase
{
    /**
     * @var list<string>
     */
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    /**
     * @param array<string, array<int, array<string, \stdClass|array<string, string>|string>>> $arguments
     */
    #[Test]
    #[DataProvider('fluidTemplatesProvider')]
    public function itBuildsSchemaCorrectlyOutOfViewHelpers(string $template, array $arguments, string $expected): void
    {
        $site = new Site('test', 1, [
            'base' => 'https://example.org/',
        ]);
        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                ['site', $site],
            ]);

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->setAttribute(ServerRequestInterface::class, $requestStub);
        $context->getTemplatePaths()->setTemplateSource($template);

        $view = new TemplateView($context);
        $view->assignMultiple($arguments);
        $view->render();

        $actual = $this->get(SchemaManager::class)->renderJsonLd();

        self::assertSame($expected, $actual);
    }

    /**
     * @return \Iterator<array<array<string, mixed>, mixed>>
     */
    public static function fluidTemplatesProvider(): \Iterator
    {
        yield 'Breadcrumb is empty' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            'arguments' => [
                'breadcrumb' => [],
            ],
            'expected' => '',
        ];

        yield 'Breadcrumb with one page' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'Some page',
                        'link' => '/',
                    ],
                ],
            ],
            'expected' => '',
        ];

        yield 'Breadcrumb with one page and render first item' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'Some page',
                        'link' => '/',
                    ],
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/"},"name":"Some page","position":"1"}}',
        ];

        yield 'Breadcrumb with two pages and minimum fields' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'Some page',
                        'link' => '/',
                    ],
                    [
                        'title' => 'Some sub page',
                        'link' => '/sub-page/',
                    ],
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/sub-page/"},"name":"Some sub page","position":"1"}}',
        ];

        yield 'Breadcrumb with multiple pages and a class given as data item (which can happen when you add a virtual category page with a domain model to it)' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'A web page',
                        'link' => '/',
                        'data' => [
                            'tx_schema_webpagetype' => 'WebPage',
                        ],
                    ],
                    [
                        'title' => 'Unicorns in TYPO3 land',
                        'link' => '/videos/unicorns-in-typo3-land/',
                        'data' => new \stdClass(),
                    ],
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"1"}}',
        ];

        yield 'Breadcrumb item with an absolute URL as link given' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'A web page',
                        'link' => '/',
                    ],
                    [
                        'title' => 'Unicorns in TYPO3 land',
                        'link' => 'https://example.org/videos/unicorns-in-typo3-land/',
                    ],
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"1"}}',
        ];

        yield 'Breadcrumb item with an absolute external URL as link given' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'Home page',
                        'link' => 'https://main.example.org/',
                    ],
                    [
                        'title' => 'Unicorns in TYPO3 land',
                        'link' => 'videos/unicorns-in-typo3-land/',
                    ],
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://main.example.org/"},"name":"Home page","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"2"}]}',
        ];
    }

    /**
     * @param string $template The Fluid template
     * @param array<string, array<int, array<string, string>>> $arguments Variables for the Fluid template
     * @param string $expectedExceptionClass The exception class
     * @param int $expectedExceptionCode The expected exception code
     */
    #[Test]
    #[DataProvider('fluidTemplatesProviderForExceptions')]
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        array $arguments,
        string $expectedExceptionClass,
        int $expectedExceptionCode,
    ): void {
        $this->expectException($expectedExceptionClass);
        $this->expectExceptionCode($expectedExceptionCode);

        /** @var RenderingContextInterface $context */
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        $view = new TemplateView($context);
        $view->assignMultiple($arguments);
        $view->render();
    }

    /**
     * @return \Iterator<array<array<string, mixed>, mixed>>
     */
    public static function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'Missing breadcrumb attribute' => [
            'template' => '<schema:breadcrumb/>',
            'arguments' => [],
            'expectedExceptionClass' => Exception::class,
            'expectedExceptionCode' => 1237823699,
        ];

        yield 'Missing title attribute' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'link' => '/',
                    ],
                ],
            ],
            'expectedExceptionClass' => MissingBreadcrumbArgumentException::class,
            'expectedExceptionCode' => 1561890280,
        ];

        yield 'Missing link attribute' => [
            'template' => '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            'arguments' => [
                'breadcrumb' => [
                    [
                        'title' => 'Some title',
                    ],
                ],
            ],
            'expectedExceptionClass' => MissingBreadcrumbArgumentException::class,
            'expectedExceptionCode' => 1561890281,
        ];
    }
}
