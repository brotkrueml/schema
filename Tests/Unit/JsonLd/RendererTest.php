<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\JsonLd;

use Brotkrueml\Schema\Core\Model\NodeIdentifier;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class RendererTest extends TestCase
{
    private Renderer $subject;

    protected function setUp(): void
    {
        $this->subject = new Renderer();
    }

    /**
     * @test
     */
    public function renderReturnsEmptyStringWhenNoTypeAdded(): void
    {
        self::assertSame('', $this->subject->render());
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function renderReturnsCorrectOutputWithOneTypeGiven(?string $id, array $properties, string $expected): void
    {
        $this->subject->addType(new GenericStub($id, $properties));

        self::assertSame(\sprintf(Extension::JSONLD_TEMPLATE, $expected), $this->subject->render());
    }

    public function dataProvider(): \Iterator
    {
        yield 'No id set and properties are empty' => [
            null,
            [
                'null-property' => null,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub"}',
        ];

        yield 'Id is set' => [
            'some-id',
            [],
            '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-id"}',
        ];

        yield 'Value is an empty string' => [
            null,
            [
                'empty-string' => '',
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub"}',
        ];

        yield 'Value is a string' => [
            null,
            [
                'some-string' => 'some string value',
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-string":"some string value"}',
        ];

        yield 'Value is the number 1 as integer' => [
            null,
            [
                'some-number' => 1,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-number":"1"}',
        ];

        yield 'Value is the number 0 as integer' => [
            null,
            [
                'some-number' => 0,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-number":"0"}',
        ];

        yield 'Value is the number 0.10 as float' => [
            null,
            [
                'some-number' => 0.10,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-number":"0.1"}',
        ];

        yield 'Value is the number 0.00 as float' => [
            null,
            [
                'some-number' => 0.00,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-number":"0"}',
        ];

        yield 'Value is a boolean (true)' => [
            null,
            [
                'some-boolean-true' => true,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-boolean-true":"https://schema.org/True"}',
        ];

        yield 'Value is a boolean (false)' => [
            null,
            [
                'some-boolean-false' => false,
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-boolean-false":"https://schema.org/False"}',
        ];

        yield 'Value is an empty array' => [
            null,
            [
                'empty-array' => [],
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub"}',
        ];

        yield 'Value is an array of strings' => [
            null,
            [
                'some-array' => [
                    'some-array-value',
                    'another-array-value',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-array":["some-array-value","another-array-value"]}',
        ];

        yield 'Value is a model' => [
            null,
            [
                'some-type' => new GenericStub(
                    'from-type-property',
                    [
                        'some-property' => 'some-value',
                    ],
                    'SomeSubTypeStub',
                ),
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-type":{"@type":"SomeSubTypeStub","@id":"from-type-property","some-property":"some-value"}}',
        ];

        yield 'Value is an array of models' => [
            null,
            [
                'some-type' => [
                    new GenericStub(
                        'from-type-property',
                        [
                            'some-property' => 'some-value',
                        ],
                        'SomeSubTypeStub',
                    ),
                    new GenericStub(
                        'from-another-type-property',
                        [
                            'another-property' => 'another-value',
                        ],
                        'AnotherSubTypeStub',
                    ),
                ],
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-type":[{"@type":"SomeSubTypeStub","@id":"from-type-property","some-property":"some-value"},{"@type":"AnotherSubTypeStub","@id":"from-another-type-property","another-property":"another-value"}]}',
        ];

        yield 'Value is of type NodeIdentifierInterface' => [
            null,
            [
                'some-property' => new NodeIdentifier('some-node-identifier-id'),
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-property":{"@id":"some-node-identifier-id"}}',
        ];

        yield 'Value is a string provoking XSS' => [
            null,
            [
                'some-string' => '</script><svg/onload=prompt(document.domain)>',
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-string":"\u003C/script\u003E\u003Csvg/onload=prompt(document.domain)\u003E"}',
        ];
    }

    /**
     * @test
     */
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedSeparately(): void
    {
        $this->subject->addType(new GenericStub('some-id'));
        $this->subject->addType(new GenericStub('another-id'));

        self::assertSame(
            \sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@graph":[{"@type":"GenericStub","@id":"some-id"},{"@type":"GenericStub","@id":"another-id"}]}',
            ),
            $this->subject->render(),
        );
    }

    /**
     * @test
     */
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedAtOnce(): void
    {
        $types = [
            new GenericStub('some-id'),
            new GenericStub('another-id'),
        ];

        $this->subject->addType(...$types);

        self::assertSame(
            \sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@graph":[{"@type":"GenericStub","@id":"some-id"},{"@type":"GenericStub","@id":"another-id"}]}',
            ),
            $this->subject->render(),
        );
    }

    /**
     * @test
     */
    public function clearTypesRemovesAllTypes(): void
    {
        $this->subject->addType(new GenericStub('some-id'));
        $this->subject->clearTypes();

        self::assertSame('', $this->subject->render());
    }
}
