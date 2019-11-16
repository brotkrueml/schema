<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers;

use Brotkrueml\Schema\Tests\Unit\Helper\TypeFixtureNamespace;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Parser;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class BreadcrumbViewHelperTest extends ViewHelperTestCase
{
    use TypeFixtureNamespace;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::setTypeNamespaceToFixtureNamespace();
    }

    public static function tearDownAfterClass(): void
    {
        static::restoreOriginalTypeNamespace();
        parent::tearDownAfterClass();
    }

    /**
     * Data provider for testing the property view helper in Fluid templates
     *
     * @return array
     */
    public function fluidTemplatesProvider(): iterable
    {
        yield 'Breadcrumb is empty' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            [
                'breadcrumb' => [],
            ],
            '',
        ];

        yield 'Breadcrumb with one page' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            [
                'breadcrumb' => [
                    [
                        'title' => 'Some page',
                        'link' => '/',
                    ],
                ],
            ],
            '',
        ];
        yield 'Breadcrumb with one page and render first item' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            [
                'breadcrumb' => [
                    [
                        'title' => 'Some page',
                        'link' => '/',
                    ],
                ],
            ],
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/"},"name":"Some page","position":"1"}}</script>',
        ];

        yield 'Breadcrumb with two pages and minimum fields' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            [
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/sub-page/"},"name":"Some sub page","position":"1"}}</script>',
        ];

        yield 'Breadcrumb with multiple pages and webpage types given' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            [
                'breadcrumb' => [
                    [
                        'title' => 'A web page',
                        'link' => '/',
                        'data' => [
                            'tx_schema_webpagetype' => 'WebPage',
                        ],
                    ],
                    [
                        'title' => 'Video overview',
                        'link' => '/videos/',
                        'data' => [
                            'tx_schema_webpagetype' => 'VideoGallery',
                        ],
                    ],
                    [
                        'title' => 'Unicorns in TYPO3 land',
                        'link' => '/videos/unicorns-in-typo3-land/',
                        'data' => [
                            'tx_schema_webpagetype' => 'ItemPage',
                        ],
                    ],
                ],
            ],
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"VideoGallery","@id":"https://example.org/videos/"},"name":"Video overview","position":"1"},{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"2"}]}</script>',
        ];

        yield 'Breadcrumb with multiple pages and a class given as data item (which can happen when you add a virtual category page with a domain model to it)' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            [
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"1"}}</script>',
        ];
    }

    /**
     * @test
     * @dataProvider fluidTemplatesProvider
     *
     * @param string $template The Fluid template
     * @param array $variables Variables for the Fluid template
     * @param string $expected The expected output
     */
    public function itBuildsSchemaCorrectlyOutOfViewHelpers(string $template, array $variables, string $expected): void
    {
        /** @noinspection PhpInternalEntityUsedInspection */
        GeneralUtility::setIndpEnv('TYPO3_SITE_URL', 'https://example.org/');

        $this->renderTemplate($template, $variables);

        $actual = $this->schemaManager->renderJsonLd();

        $this->assertSame($expected, $actual);
    }

    /**
     * Data provider for some cases where exceptions are thrown when using the property view helper incorrectly
     *
     * @return array
     */
    public function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'Missing breadcrumb attribute' => [
            '<schema:breadcrumb/>',
            [],
            Parser\Exception::class,
            1237823699,
        ];

        yield 'Missing title attribute' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            [
                'breadcrumb' => [
                    [
                        'link' => '/',
                    ]
                ],
            ],
            ViewHelper\Exception::class,
            1561890280,
        ];

        yield 'Missing link attribute' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            [
                'breadcrumb' => [
                    [
                        'title' => 'Some title',
                    ]
                ],
            ],
            ViewHelper\Exception::class,
            1561890281,
        ];
    }

    /**
     * @test
     * @dataProvider fluidTemplatesProviderForExceptions
     *
     * @param string $template The Fluid template
     * @param array $variables Variables for the Fluid template
     * @param string $exceptionClass The exception class
     * @param int $expectedExceptionCode The expected exception code
     */
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        array $variables,
        string $exceptionClass,
        int $expectedExceptionCode
    ): void {
        $this->expectException($exceptionClass);
        $this->expectExceptionCode($expectedExceptionCode);

        $this->renderTemplate($template, $variables);
    }
}
