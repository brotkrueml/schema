<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\TypoScript;

use Brotkrueml\Schema\TypoScript\PropertiesAdder;
use Brotkrueml\Schema\TypoScript\SchemaContentObject;
use Brotkrueml\Schema\TypoScript\TypeBuilder;
use Brotkrueml\Schema\TypoScript\TypoScriptConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(PropertiesAdder::class)]
#[CoversClass(SchemaContentObject::class)]
#[CoversClass(TypeBuilder::class)]
#[CoversClass(TypoScriptConverter::class)]
final class SchemaContentObjectTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'typo3/cms-adminpanel',
    ];

    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    /**
     * @var array<string, string>
     */
    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/schema/Tests/Functional/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    /**
     * @var array<string, array<string, array<string, string>>>
     */
    protected array $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'schema' => [
                'automaticBreadcrumbSchemaGeneration' => '0',
                'automaticWebPageSchemaGeneration' => '0',
                'embedMarkupOnNoindexPages' => '0',
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        \file_put_contents($this->getInstancePath() . '/typo3temp/var/log/typo3_0493d91d8e.log', '');
    }

    #[Test]
    #[DataProvider('possibleTypoScriptConfigurationsWithNoResultProvider')]
    public function returnsNoSchema(
        string $typoScriptSetup,
        array $expectedLogEntries,
    ): void {
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/Database.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => $typoScriptSetup,
            ],
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendSubRequest($request)->getBody();

        self::assertStringNotContainsString('ext-schema-jsonld', $content);
        $this->assertHasLogEntries($expectedLogEntries);
    }

    public static function possibleTypoScriptConfigurationsWithNoResultProvider(): iterable
    {
        yield 'Without SCHEMA content object no JSON-LD is embedded' => [
            'typoScriptSetup' => <<< TYPOSCRIPT
page = PAGE
page.10 = TEXT
TYPOSCRIPT,
            'expectedLogEntries' => [],
        ];

        yield 'With a falsy condition no JSON-LD is embedded' => [
            'typoScriptSetup' => <<< TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    if.isTrue = 0
    type = WebPage
}
TYPOSCRIPT,
            'expectedLogEntries' => [],
        ];

        yield 'Unknown type is given no JSON-LD is embedded and an error is logged' => [
            'typoScriptSetup' => <<< TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = Unknown
TYPOSCRIPT,
            'expectedLogEntries' => [
                [
                    'type' => 'ERROR',
                    'component' => 'Brotkrueml.Schema.TypoScript.TypeBuilder',
                    'message' => 'Use of unknown type "Unknown"',
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('possibleTypoScriptConfigurationsProvider')]
    public function returnsExpectedSchemaInHtml(
        string $typoScriptSetup,
        array $expectedJsonLd,
    ): void {
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/Database.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => $typoScriptSetup,
            ],
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendSubRequest($request)->getBody();

        $this->assertHasJsonLd($expectedJsonLd, $content);
        $this->assertHasLogEntries([]);
    }

    public static function possibleTypoScriptConfigurationsProvider(): iterable
    {
        yield 'type and id' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.id = https://example.com/test#id
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebPage',
                '@id' => 'https://example.com/test#id',
            ],
        ];

        yield 'stdWrap can be used on type' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.type.override = ItemPage
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'ItemPage',
            ],
        ];

        yield 'type and empty id' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.id =
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebPage',
            ],
        ];

        yield 'Plain property value' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.properties.url = https://example.com/url.html
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebPage',
                'url' => 'https://example.com/url.html',
            ],
        ];

        yield 'type and empty property' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.properties.publisher =
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebPage',
            ],
        ];

        yield 'type and property which is evaluated to empty' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.properties.publisher.if.isTrue = 0
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebPage',
            ],
        ];

        yield 'Only id in a sub-property' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.publisher = SCHEMA
    properties.publisher.id = https://example.com/publisher
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
                'publisher' => [
                    '@id' => 'https://example.com/publisher',
                ],
            ],
        ];

        yield 'Only id in a sub-property (which is empty)' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.publisher = SCHEMA
    properties.publisher.id =
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
            ],
        ];

        yield 'Only id in a sub-property (which is evaluated to empty)' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.publisher = SCHEMA
    properties.publisher.id.if.isTrue = 0
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
            ],
        ];

        yield 'type with nested sub properties' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = Organization
    properties {
        logo = SCHEMA
        logo {
            type = ImageObject
            id = https://example.com/logo.png
            properties {
                url = https://example.com/logo.png
                contentUrl = https://example.com/logo.png
                caption = Some Caption
            }
        }
    }
}
TYPOSCRIPT,
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
        ];

        yield 'id with a typolink for evaluation' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebPage
    id.typolink {
        parameter = t3://page?uid=1
        forceAbsoluteUrl = 1
        returnLast = url
    }
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebPage',
                '@id' => 'http://localhost/index.html',
            ],
        ];

        yield 'property with a typolink for evaluation' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.url.typolink {
        parameter = t3://page?uid=1
        forceAbsoluteUrl = 1
        returnLast = url
    }
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
                'url' => 'http://localhost/index.html',
            ],
        ];

        yield 'property with string value and stdWrap applied' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.sameAs = HTTPS://EXAMPLE.COM/
    properties.sameAs.case = lower
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
                'sameAs' => 'https://example.com/',
            ],
        ];

        yield 'multiple values for a property with static values' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.sameAs.10 = https://example.net/
    properties.sameAs.20 = https://example.com/
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
                'sameAs' => ['https://example.net/', 'https://example.com/'],
            ],
        ];

        yield 'multiple values for a property with stdWrap' => [
            'typoScriptSetup' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10 {
    type = WebSite
    properties.sameAs {
	    10 = static string

        20 = via stdWrap strPad
        20.strPad {
            length = 30
            padWith = %
            type = both
        }

        30.cObject = TEXT
        30.cObject.value = via TEXT cObject
    }
}
TYPOSCRIPT,
            'expectedJsonLd' => [
                '@context' => 'https://schema.org/',
                '@type' => 'WebSite',
                'sameAs' => ['static string', '%%%%%%via stdWrap strPad%%%%%%', 'via TEXT cObject'],
            ],
        ];
    }

    #[Test]
    public function returnsSchemaAndAddsErrorForUnknownProperty(): void
    {
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/Database.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => <<<TYPOSCRIPT
page = PAGE
page.10 = SCHEMA
page.10.type = WebPage
page.10.properties.unknownProperty = some value
TYPOSCRIPT,
            ],
        );

        $request = new InternalRequest();
        $content = (string) $this->executeFrontendSubRequest($request)->getBody();

        $this->assertHasJsonLd([
            '@context' => 'https://schema.org/',
            '@type' => 'WebPage',
        ], $content);
        $this->assertHasLogEntries([
            [
                'type' => 'ERROR',
                'component' => 'Brotkrueml.Schema.TypoScript.PropertiesAdder',
                'message' => 'Use of unknown property "unknownProperty" for type "WebPage"',
            ],
        ]);
    }

    private function assertHasJsonLd(array $expectedJsonLd, string $content): void
    {
        $jsonLd = \json_encode($expectedJsonLd, \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR);
        self::assertStringContainsString(
            '<script type="application/ld+json" id="ext-schema-jsonld">' . $jsonLd . '</script>',
            $content,
            'Content did not include expected JSON LD',
        );
    }

    /**
     * @param array<array{type: string, component: string, message: string}> $entries
     */
    private function assertHasLogEntries(array $entries): void
    {
        $logFileContent = \file_get_contents(
            $this->getInstancePath() . '/typo3temp/var/log/typo3_0493d91d8e.log',
        );
        $logEntries = \array_filter(\explode("\n", $logFileContent));

        self::assertCount(
            \count($entries),
            $logEntries,
            'Number of expected log entries did not match. Got the following: ' . \PHP_EOL . $logFileContent,
        );

        foreach ($logEntries as $index => $logEntry) {
            self::assertStringContainsString('[' . $entries[$index]['type'] . ']', $logEntry, 'Type of log entry does not match.');
            self::assertStringContainsString('component="' . $entries[$index]['component'] . '"', $logEntry, 'Component of log entry does not match.');
            self::assertStringContainsString($entries[$index]['message'], \trim($logEntry), 'Message of log entry does not match.');
        }
    }
}
