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
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/schema',
    ];

    /**
     * @var array<string, string>
     */
    protected $pathsToLinkInTestInstance = [
        'typo3conf/ext/schema/Tests/Functional/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    /**
     * @var array<string, array<string, array<string, string>>>
     */
    protected $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'schema' => [
                'automaticBreadcrumbSchemaGeneration' => '0',
                'automaticWebPageSchemaGeneration' => '0',
                'embedMarkupInBodySection' => '1',
                'embedMarkupOnNoindexPages' => '0',
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        file_put_contents($this->getInstancePath() . '/typo3temp/var/log/typo3_0493d91d8e.log', '');
    }

    /**
     * @test
     * @dataProvider possibleTypoScriptConfigurationsWithNoResult
     */
    public function returnsNoSchema(
        array $typoScriptSetup,
        array $expectedLogEntries
    ): void {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, $typoScriptSetup) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string)$this->executeFrontendRequest($request)->getBody();

        self::assertStringNotContainsString('ext-schema-jsonld', $content);
        $this->assertHasLogEntries($expectedLogEntries);
    }

    public function possibleTypoScriptConfigurationsWithNoResult(): array
    {
        return [
            'Default' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = TEXT',
                ],
                'expectedLogEntries' => [],
            ],
            'Falsy Condition' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10 {',
                    'if.isTrue = 0',
                    'type = WebPage',
                    '}',
                ],
                'expectedLogEntries' => [],
            ],
            'Unknown Type' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = Unknown',
                ],
                'expectedLogEntries' => [
                    [
                        'type' => 'ERROR',
                        'component' => 'Brotkrueml.Schema.TypoScript.TypeBuilder',
                        'message' => 'Tried to create unknown Schema type "Unknown".',
                    ],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider possibleTypoScriptConfigurations
     */
    public function returnsExpectedSchemaInHtml(
        array $typoScriptSetup,
        array $expectedJsonLd
    ): void {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, $typoScriptSetup) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string)$this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd($expectedJsonLd, $content);
        $this->assertHasLogEntries([]);
    }

    public function possibleTypoScriptConfigurations(): array
    {
        return [
            'Type And ID' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.id = https://example.com/test#id',
                ],
                'expectedJsonLd' => [
                    '@context' => 'https://schema.org/',
                    '@type' => 'WebPage',
                    '@id' => 'https://example.com/test#id',
                ],
            ],
            'Plain Property Value' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.properties.url = https://example.com/url.html',
                ],
                'expectedJsonLd' => [
                    '@context' => 'https://schema.org/',
                    '@type' => 'WebPage',
                    'url' => 'https://example.com/url.html',
                ],
            ],
            'ID Only Property' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebSite',
                    'page.10.properties.publisher = SCHEMA',
                    'page.10.properties.publisher.id = https://example.com/publisher',
                ],
                'expectedJsonLd' => [
                    '@context' => 'https://schema.org/',
                    '@type' => 'WebSite',
                    'publisher' => [
                        '@id' => 'https://example.com/publisher',
                    ],
                ],
            ],
            'Type Property' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = Organization',
                    'page.10.properties.logo = SCHEMA',
                    'page.10.properties.logo.type = ImageObject',
                    'page.10.properties.logo.id = https://example.com/logo.png',
                    'page.10.properties.logo.properties.url = https://example.com/logo.png',
                    'page.10.properties.logo.properties.contentUrl = https://example.com/logo.png',
                    'page.10.properties.logo.properties.caption = Some Caption',
                ],
                'expectedJsonLd' => [
                    '@context' => 'https://schema.org/',
                    '@type' => 'Organization',
                    'logo' => [
                        '@type' => 'ImageObject',
                        '@id' => 'https://example.com/logo.png',
                        'caption' => 'Some Caption',
                        'contentUrl' => 'https://example.com/logo.png',
                        'url' => 'https://example.com/logo.png',
                    ],
                ],
            ],
            'Evaluated ID' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.id.typolink.parameter = t3://page?uid=1',
                    'page.10.id.typolink.forceAbsoluteUrl = 1',
                    'page.10.id.typolink.returnLast = url',
                ],
                'expectedJsonLd' => [
                    '@context' => 'https://schema.org/',
                    '@type' => 'WebPage',
                    '@id' => 'http://localhost/index.html',
                ],
            ],
            'Evaluated Property' => [
                'typoScriptSetup' => [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebSite',
                    'page.10.properties.url.typolink.parameter = t3://page?uid=1',
                    'page.10.properties.url.typolink.forceAbsoluteUrl = 1',
                    'page.10.properties.url.typolink.returnLast = url',
                ],
                'expectedJsonLd' => [
                    '@context' => 'https://schema.org/',
                    '@type' => 'WebSite',
                    'url' => 'http://localhost/index.html',
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function returnsSchemaAndAddsErrorForUnknownProperty(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => implode(PHP_EOL, [
                    'page = PAGE',
                    'page.10 = SCHEMA',
                    'page.10.type = WebPage',
                    'page.10.properties.unknownProperty = some value',
                ]) . PHP_EOL,
            ]
        );

        $request = new InternalRequest();
        $content = (string)$this->executeFrontendRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebPage',
        ], $content);
        $this->assertHasLogEntries([
            [
                'type' => 'ERROR',
                'component' => 'Brotkrueml.Schema.TypoScript.PropertiesAdder',
                'message' => 'Tried to set unknown property "unknownProperty".',
            ],
        ]);
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

    /**
     * @param array<array<type: string, component: string, message: string>> $entries
     */
    private function assertHasLogEntries(array $entries): void
    {
        $logFileContent = file_get_contents(
            $this->getInstancePath() . '/typo3temp/var/log/typo3_0493d91d8e.log'
        );
        $logEntries = array_filter(explode("\n", $logFileContent));

        self::assertCount(
            count($entries),
            $logEntries,
            'Number of expected log entries did not match. Got the following: ' . PHP_EOL . $logFileContent
        );

        foreach ($logEntries as $index => $logEntry) {
            self::assertStringContainsString('[' . $entries[$index]['type'] . ']', $logEntry, 'Type of log entry does not match.');
            self::assertStringContainsString('component="' . $entries[$index]['component'] . '"', $logEntry, 'Component of log entry does not match.');
            self::assertStringEndsWith($entries[$index]['message'], trim($logEntry), 'Message of log entry does not match.');
        }
    }
}
