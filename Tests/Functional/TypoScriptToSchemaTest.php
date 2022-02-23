<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * @testdox Conversion of TypoScript to Schema
 */
class TypoScriptToSchemaTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/schema',
    ];

    protected $pathsToLinkInTestInstance = [
        'typo3conf/ext/schema/Tests/Functional/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    protected $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'schema' => [
                'automaticBreadcrumbSchemaGeneration' => '1',
                'automaticWebPageSchemaGeneration' => '0',
                'embedMarkupInBodySection' => '1',
                'embedMarkupOnNoindexPages' => '0',
            ],
        ],
    ];

    /**
     * @test
     */
    public function returnsNoSchemaByDefault(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = TEXT',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        self::assertStringNotContainsString('ext-schema-jsonld', $content);
    }

    /**
     * @test
     */
    public function returnsNoSchemaForFalsyCondition(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10 {',
                    'if.isTrue = 0',
                    'type = WebPage',
                    '}',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        self::assertStringNotContainsString('ext-schema-jsonld', $content);
    }

    /**
     * @test
     */
    public function returnsNoSchemaForUnkownType(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = Unkown',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        self::assertStringNotContainsString('ext-schema-jsonld', $content);
    }

    /**
     * @test
     */
    public function returnsSchemaWithTypeAndId(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.id = https://example.com/test#id',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebPage',
            '@id' => 'https://example.com/test#id',
        ], $content);
    }

    /**
     * @test
     */
    public function returnsSchemaWithPlainPropertyValue(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.properties.url = https://example.com/url.html',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebPage',
            'url' => 'https://example.com/url.html',
        ], $content);
    }

    /**
     * @test
     */
    public function returnsSchemaWithIdOnlyProperty(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebSite',
                    'page.10.properties.publisher = SCHEMA',
                    'page.10.properties.publisher.id = https://example.com/publisher',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebSite',
            'publisher' => [
                'https://example.com/publisher',
            ],
        ], $content);
    }

    /**
     * @test
     */
    public function returnsSchemaWithTypeProperty(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = Organization',
                    'page.10.properties.logo = SCHEMA',
                    'page.10.properties.logo.type = ImageObject',
                    'page.10.properties.logo.id = https://example.com/logo.png',
                    'page.10.properties.logo.properties.url = https://example.com/logo.png',
                    'page.10.properties.logo.properties.contentUrl = https://example.com/logo.png',
                    'page.10.properties.logo.properties.caption = Some Caption',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'Organization',
            'logo' => [
                '@type' => 'ImageObject',
                '@id' => 'https://example.com/logo.png',
                'caption' => 'Some Caption',
                'contentUrl' => 'https://example.com/logo.png',
                'url' => 'https://example.com/logo.png',
            ],
        ], $content);
    }

    /**
     * @test
     */
    public function returnsSchemaWithEvaluatedId(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.id.typolink.parameter = t3://page?uid=1',
                    'page.10.id.typolink.forceAbsoluteUrl = 1',
                    'page.10.id.typolink.returnLast = url',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebPage',
            '@id' => 'http://localhost/index.html',
        ], $content);
    }

    /**
     * @test
     */
    public function returnsSchemaWithEvaluatedProperty(): void
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database.xml');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebSite',
                    'page.10.properties.publisher = SCHEMA',
                    'page.10.properties.publisher.id.typolink.parameter = t3://page?uid=1',
                    'page.10.properties.publisher.id.typolink.forceAbsoluteUrl = 1',
                    'page.10.properties.publisher.id.typolink.returnLast = url',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebSite',
            'publisher' => [
                'http://localhost/index.html',
            ],
        ], $content);
    }

    private function assertHasJsonLd(array $expectedJsonLd, string $content): void
    {
        $jsonLd = json_encode($expectedJsonLd, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        self::assertStringContainsString(
            '<script type="application/ld+json" id="ext-schema-jsonld">' . $jsonLd . '</script>',
            $content,
            'Content did not include expected JSON LD'
        );
    }
}
