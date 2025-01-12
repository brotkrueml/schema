<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\TypoScript;

use Brotkrueml\Schema\TypoScript\TypoScriptConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypoScriptConverter::class)]
final class TypoScriptConverterTest extends TestCase
{
    /**
     * data provider for convertTypoScriptArrayToPlainArray
     */
    public static function convertTypoScriptArrayToPlainArrayTestdata(): \Iterator
    {
        yield 'simple typoscript array' => [
            'typoScriptSettings' => [
                '10.' => [
                    'value' => 'Hello World!',
                    'foo.' => [
                        'bar' => 5,
                    ],
                ],
                '10' => 'TEXT',
            ],
            'expectedSettings' => [
                '10' => [
                    'value' => 'Hello World!',
                    'foo' => [
                        'bar' => 5,
                    ],
                    '_typoScriptNodeValue' => 'TEXT',
                ],
            ],
        ];

        yield 'typoscript array with a dot key which value is not an array' => [
            'typoScriptSettings' => [
                '10.' => 42,
                '10' => 'TEXT',
            ],
            'expectedSettings' => [
                '10' => null,
                '10.' => 42,
            ],
        ];

        yield 'typoscript with intermediate dots' => [
            'typoScriptSettings' => [
                '10.' => [
                    'value' => 'Hello World!',
                    'foo.' => [
                        'bar' => 5,
                    ],
                ],
                '10' => 'TEXT',
            ],
            'expectedSettings' => [
                '10' => [
                    'value' => 'Hello World!',
                    'foo' => [
                        'bar' => 5,
                    ],
                    '_typoScriptNodeValue' => 'TEXT',
                ],
            ],
        ];

        yield 'typoscript array with changed order' => [
            'typoScriptSettings' => [
                '10' => 'TEXT',
                '10.' => [
                    'value' => 'Hello World!',
                    'foo.' => [
                        'bar' => 5,
                    ],
                ],
            ],
            'expectedSettings' => [
                '10' => [
                    'value' => 'Hello World!',
                    'foo' => [
                        'bar' => 5,
                    ],
                    '_typoScriptNodeValue' => 'TEXT',
                ],
            ],
        ];

        yield 'nested typoscript array' => [
            'typoScriptSettings' => [
                '10' => 'COA',
                '10.' => [
                    '10' => 'TEXT',
                    '10.' => [
                        'value' => 'Hello World!',
                        'foo.' => [
                            'bar' => 5,
                        ],
                    ],
                    '20' => 'COA',
                    '20.' => [
                        '10' => 'TEXT',
                        '10.' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                        ],
                        '20' => 'TEXT',
                        '20.' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                        ],
                    ],
                    '30' => 'custom',
                ],
            ],
            'expectedSettings' => [
                '10' => [
                    '10' => [
                        'value' => 'Hello World!',
                        'foo' => [
                            'bar' => 5,
                        ],
                        '_typoScriptNodeValue' => 'TEXT',
                    ],
                    '20' => [
                        '10' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                            '_typoScriptNodeValue' => 'TEXT',
                        ],
                        '20' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                            '_typoScriptNodeValue' => 'TEXT',
                        ],
                        '_typoScriptNodeValue' => 'COA',
                    ],
                    '30' => 'custom',
                    '_typoScriptNodeValue' => 'COA',
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('convertTypoScriptArrayToPlainArrayTestdata')]
    public function convertTypoScriptArrayToPlainArrayRemovesTrailingDotsWithChangedOrderInTheTypoScriptArray(
        array $typoScriptSettings,
        array $expectedSettings,
    ): void {
        $typoScriptService = new TypoScriptConverter();
        $processedSettings = $typoScriptService->convertTypoScriptArrayToPlainArray($typoScriptSettings);
        self::assertEquals($expectedSettings, $processedSettings);
    }

    /**
     * Data provider for testcase "convertPlainArrayToTypoScriptArray"
     */
    public static function convertPlainArrayToTypoScriptArrayTestdata(): \Iterator
    {
        yield 'simple typoscript' => [
            'plainSettings' => [
                '10' => [
                    'value' => 'Hallo',
                    '_typoScriptNodeValue' => 'TEXT',
                ],
            ],
            'expectedSettings' => [
                '10' => 'TEXT',
                '10.' => [
                    'value' => 'Hallo',
                ],
            ],
        ];

        yield 'typoscript with null value' => [
            'plainSettings' => [
                '10' => [
                    'value' => 'Hallo',
                    '_typoScriptNodeValue' => 'TEXT',
                ],
                '20' => null,
            ],
            'expectedSettings' => [
                '10' => 'TEXT',
                '10.' => [
                    'value' => 'Hallo',
                ],
                '20' => '',
            ],
        ];

        yield 'ts with dots in key' => [
            'plainSettings' => [
                '1.0' => [
                    'value' => 'Hallo',
                    '_typoScriptNodeValue' => 'TEXT',
                ],
            ],
            'expectedSettings' => [
                '1.0' => 'TEXT',
                '1.0.' => [
                    'value' => 'Hallo',
                ],
            ],
        ];

        yield 'ts with backslashes in key' => [
            'plainSettings' => [
                '1\0\\' => [
                    'value' => 'Hallo',
                    '_typoScriptNodeValue' => 'TEXT',
                ],
            ],
            'expectedSettings' => [
                '1\0\\' => 'TEXT',
                '1\0\.' => [
                    'value' => 'Hallo',
                ],
            ],
        ];

        yield 'bigger typoscript' => [
            'plainSettings' => [
                '10' => [
                    '10' => [
                        'value' => 'Hello World!',
                        'foo' => [
                            'bar' => 5,
                        ],
                        '_typoScriptNodeValue' => 'TEXT',
                    ],
                    '20' => [
                        '10' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                            '_typoScriptNodeValue' => 'TEXT',
                        ],
                        '20' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                            '_typoScriptNodeValue' => 'TEXT',
                        ],
                        '_typoScriptNodeValue' => 'COA',
                    ],
                    '_typoScriptNodeValue' => 'COA',
                ],
            ],
            'expectedSettings' => [
                '10' => 'COA',
                '10.' => [
                    '10' => 'TEXT',
                    '10.' => [
                        'value' => 'Hello World!',
                        'foo.' => [
                            'bar' => 5,
                        ],
                    ],
                    '20' => 'COA',
                    '20.' => [
                        '10' => 'TEXT',
                        '10.' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                        ],
                        '20' => 'TEXT',
                        '20.' => [
                            'value' => 'Test',
                            'wrap' => '[|]',
                        ],
                    ],
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('convertPlainArrayToTypoScriptArrayTestdata')]
    public function convertPlainArrayToTypoScriptArray(array $plainSettings, array $expectedSettings): void
    {
        $typoScriptConverter = new TypoScriptConverter();
        $converted = $typoScriptConverter->convertPlainArrayToTypoScriptArray($plainSettings);
        self::assertEquals($converted, $expectedSettings);
    }

    public function explodeConfigurationForOptionSplitProvider(): array
    {
        return [
            [
                [
                    'splitConfiguration' => 'a',
                ],
                3,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'a',
                    ],
                    2 => [
                        'splitConfiguration' => 'a',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a || b || c',
                ],
                5,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'b',
                    ],
                    2 => [
                        'splitConfiguration' => 'c',
                    ],
                    3 => [
                        'splitConfiguration' => 'c',
                    ],
                    4 => [
                        'splitConfiguration' => 'c',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a || b |*| c',
                ],
                5,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'b',
                    ],
                    2 => [
                        'splitConfiguration' => 'c',
                    ],
                    3 => [
                        'splitConfiguration' => 'c',
                    ],
                    4 => [
                        'splitConfiguration' => 'c',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a || b |*| c |*| d || e',
                ],
                7,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'b',
                    ],
                    2 => [
                        'splitConfiguration' => 'c',
                    ],
                    3 => [
                        'splitConfiguration' => 'c',
                    ],
                    4 => [
                        'splitConfiguration' => 'c',
                    ],
                    5 => [
                        'splitConfiguration' => 'd',
                    ],
                    6 => [
                        'splitConfiguration' => 'e',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a || b |*| c |*| d || e',
                ],
                4,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'b',
                    ],
                    2 => [
                        'splitConfiguration' => 'd',
                    ],
                    3 => [
                        'splitConfiguration' => 'e',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a || b |*| c |*| d || e',
                ],
                3,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'd',
                    ],
                    2 => [
                        'splitConfiguration' => 'e',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a || b |*||*| c || d',
                ],
                7,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'b',
                    ],
                    2 => [
                        'splitConfiguration' => 'b',
                    ],
                    3 => [
                        'splitConfiguration' => 'b',
                    ],
                    4 => [
                        'splitConfiguration' => 'b',
                    ],
                    5 => [
                        'splitConfiguration' => 'c',
                    ],
                    6 => [
                        'splitConfiguration' => 'd',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => '|*||*| a || b',
                ],
                7,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'a',
                    ],
                    2 => [
                        'splitConfiguration' => 'a',
                    ],
                    3 => [
                        'splitConfiguration' => 'a',
                    ],
                    4 => [
                        'splitConfiguration' => 'a',
                    ],
                    5 => [
                        'splitConfiguration' => 'a',
                    ],
                    6 => [
                        'splitConfiguration' => 'b',
                    ],
                ],
            ],
            [
                [
                    'splitConfiguration' => 'a |*| b || c |*|',
                ],
                7,
                [
                    0 => [
                        'splitConfiguration' => 'a',
                    ],
                    1 => [
                        'splitConfiguration' => 'b',
                    ],
                    2 => [
                        'splitConfiguration' => 'c',
                    ],
                    3 => [
                        'splitConfiguration' => 'b',
                    ],
                    4 => [
                        'splitConfiguration' => 'c',
                    ],
                    5 => [
                        'splitConfiguration' => 'b',
                    ],
                    6 => [
                        'splitConfiguration' => 'c',
                    ],
                ],
            ],
        ];
    }
}
