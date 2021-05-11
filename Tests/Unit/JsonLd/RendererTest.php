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
use Brotkrueml\Schema\Tests\Fixtures\Renderer\StubType;
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
        $this->subject->addType(new StubType($id, $properties));

        self::assertSame(\sprintf(Extension::JSONLD_TEMPLATE, $expected), $this->subject->render());
    }

    public function dataProvider(): \Iterator
    {
        yield 'No id set and properties are empty' => [
            null,
            [
                'null-property' => null,
                'empty-string-property' => '',
            ],
            '{"@context":"https://schema.org/","@type":"StubType"}',
        ];

        yield 'Id is set' => [
            'some-id',
            [],
            '{"@context":"https://schema.org/","@type":"StubType","@id":"some-id"}',
        ];

        yield 'Value is a string' => [
            null,
            [
                'some-string' => 'some string value',
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-string":"some string value"}',
        ];

        yield 'Value is a number as integer' => [
            null,
            [
                'some-number' => 1,
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-number":"1"}',
        ];

        yield 'Value is the number 0 as integer' => [
            null,
            [
                'some-number' => 0,
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-number":"0"}',
        ];

        yield 'Value is the number 0.10 as float' => [
            null,
            [
                'some-number' => 0.10,
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-number":"0.1"}',
        ];

        yield 'Value is the number 0.00 as float' => [
            null,
            [
                'some-number' => 0.00,
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-number":"0"}',
        ];

        yield 'Value is a boolean (true)' => [
            null,
            [
                'some-boolean-true' => true,
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-boolean-true":"https://schema.org/True"}',
        ];

        yield 'Value is a boolean (false)' => [
            null,
            [
                'some-boolean-false' => false,
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-boolean-false":"https://schema.org/False"}',
        ];

        yield 'Value is an array of strings' => [
            null,
            [
                'some-array' => [
                    'some-array-value',
                    'another-array-value',
                ],
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-array":["some-array-value","another-array-value"]}',
        ];

        yield 'Value is a model' => [
            null,
            [
                'some-type' => new StubType(
                    'from-type-property',
                    ['some-property' => 'some-value'],
                    'SomeSubTypeStub'
                ),
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-type":{"@type":"SomeSubTypeStub","@id":"from-type-property","some-property":"some-value"}}',
        ];

        yield 'Value is an array of models' => [
            null,
            [
                'some-type' => [
                    new StubType(
                        'from-type-property',
                        ['some-property' => 'some-value'],
                        'SomeSubTypeStub'
                    ),
                    new StubType(
                        'from-another-type-property',
                        ['another-property' => 'another-value'],
                        'AnotherSubTypeStub'
                    ),
                ],
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-type":[{"@type":"SomeSubTypeStub","@id":"from-type-property","some-property":"some-value"},{"@type":"AnotherSubTypeStub","@id":"from-another-type-property","another-property":"another-value"}]}',
        ];

        yield 'Value is of type NodeIdentifierInterface' => [
            null,
            [
                'some-property' => new NodeIdentifier('some-node-identifier-id'),
            ],
            '{"@context":"https://schema.org/","@type":"StubType","some-property":{"@id":"some-node-identifier-id"}}',
        ];
    }

    /**
     * @test
     */
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedSeparately(): void
    {
        $this->subject->addType(new StubType('some-id'));
        $this->subject->addType(new StubType('another-id'));

        self::assertSame(
            \sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@graph":[{"@type":"StubType","@id":"some-id"},{"@type":"StubType","@id":"another-id"}]}'
            ),
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedAtOnce(): void
    {
        $types = [
            new StubType('some-id'),
            new StubType('another-id'),
        ];

        $this->subject->addType(...$types);

        self::assertSame(
            \sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"https://schema.org/","@graph":[{"@type":"StubType","@id":"some-id"},{"@type":"StubType","@id":"another-id"}]}'
            ),
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function clearTypesRemovesAllTypes(): void
    {
        $this->subject->addType(new StubType('some-id'));
        $this->subject->clearTypes();

        self::assertSame('', $this->subject->render());
    }
}
