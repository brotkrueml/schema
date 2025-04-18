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
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Helper\TypeProviderWithFixturesTrait;
use Brotkrueml\Schema\Type\TypeProvider;
use Brotkrueml\Schema\ViewHelpers\BreadcrumbViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Parser\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper;

#[CoversClass(BreadcrumbViewHelper::class)]
final class BreadcrumbViewHelperTest extends ViewHelperTestCase
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
        parent::tearDown();
        GeneralUtility::purgeInstances();
    }

    /**
     * Data provider for testing the property view helper in Fluid templates
     */
    public static function fluidTemplatesProvider(): \Iterator
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
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/"},"name":"Some page","position":"1"}}',
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
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/sub-page/"},"name":"Some sub page","position":"1"}}',
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
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"1"}}',
        ];

        yield 'Breadcrumb item with an absolute URL as link given' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}"/>',
            [
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
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"1"}}',
        ];

        yield 'Breadcrumb item with an absolute external URL as link given' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            [
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
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://main.example.org/"},"name":"Home page","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"2"}]}',
        ];
    }

    /**
     * @param string $template The Fluid template
     * @param array $variables Variables for the Fluid template
     * @param string $expected The expected output
     */
    #[Test]
    #[DataProvider('fluidTemplatesProvider')]
    public function itBuildsSchemaCorrectlyOutOfViewHelpers(string $template, array $variables, string $expected): void
    {
        /** @noinspection PhpInternalEntityUsedInspection */
        GeneralUtility::setIndpEnv('TYPO3_SITE_URL', 'https://example.org/');

        $this->renderTemplate($template, $variables);

        $actual = $this->schemaManager->renderJsonLd();

        self::assertSame($expected === '' ? '' : \sprintf(Extension::JSONLD_TEMPLATE, $expected), $actual);
    }

    #[Test]
    public function breadcrumbWithMultiplePagesAndWebPageTypesGiven(): never
    {
        self::markTestSkipped('Skipped, see https://github.com/brotkrueml/schema/issues/101');

        /** @noinspection PhpInternalEntityUsedInspection */
        GeneralUtility::setIndpEnv('TYPO3_SITE_URL', 'https://example.org/');

        $cacheFrontendStub = self::createStub(PhpFrontend::class);
        $cacheFrontendStub
            ->method('has')
            ->willReturn(true);
        $cacheFrontendStub
            ->method('get')
            ->with(self::anything())
            ->willReturn([]);
        $cacheFrontendStub
            ->method('require')
            ->willReturn([
                'ItemPage' => FixtureType\ItemPage::class,
                'VideoGallery' => FixtureType\VideoGallery::class,
                'WebPage' => FixtureType\WebPage::class,
            ]);

        $cacheManagerStub = self::createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with(self::anything())
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        $packageManagerStub = self::createStub(PackageManager::class);
        $packageManagerStub
            ->method('getActivePackages')
            ->willReturn([]);

        GeneralUtility::setSingletonInstance(PackageManager::class, $packageManagerStub);

        $variables = [
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
        ];

        $this->renderTemplate('<schema:breadcrumb breadcrumb="{breadcrumb}"/>', $variables);

        $actual = $this->schemaManager->renderJsonLd();
        $expected = \sprintf(
            Extension::JSONLD_TEMPLATE,
            '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"VideoGallery","@id":"https://example.org/videos/"},"name":"Video overview","position":"1"},{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/videos/unicorns-in-typo3-land/"},"name":"Unicorns in TYPO3 land","position":"2"}]}',
        );

        self::assertSame($expected, $actual);
    }

    /**
     * Data provider for some cases where exceptions are thrown when using the property view helper incorrectly
     *
     * @return array
     */
    public static function fluidTemplatesProviderForExceptions(): iterable
    {
        yield 'Missing breadcrumb attribute' => [
            '<schema:breadcrumb/>',
            [],
            Exception::class,
            1237823699,
        ];

        yield 'Missing title attribute' => [
            '<schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>',
            [
                'breadcrumb' => [
                    [
                        'link' => '/',
                    ],
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
                    ],
                ],
            ],
            ViewHelper\Exception::class,
            1561890281,
        ];
    }

    /**
     * @param string $template The Fluid template
     * @param array $variables Variables for the Fluid template
     * @param string $exceptionClass The exception class
     * @param int $expectedExceptionCode The expected exception code
     */
    #[Test]
    #[DataProvider('fluidTemplatesProviderForExceptions')]
    public function itThrowsExceptionWhenViewHelperIsUsedIncorrectly(
        string $template,
        array $variables,
        string $exceptionClass,
        int $expectedExceptionCode,
    ): void {
        $this->expectException($exceptionClass);
        $this->expectExceptionCode($expectedExceptionCode);

        $this->renderTemplate($template, $variables);
    }
}
