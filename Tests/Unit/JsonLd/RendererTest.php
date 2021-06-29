<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\JsonLd;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\JsonLd\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    /** @var Renderer */
    private $subject;

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
        $this->subject->addType($this->createTypeStub($id, $properties));

        self::assertSame(\sprintf(Extension::JSONLD_TEMPLATE, $expected), $this->subject->render());
    }

    public function dataProvider(): \Generator
    {
        yield 'No id set and properties are empty' => [
            null,
            [
                'null-property' => null,
            ],
            '{"@context":"http://schema.org","@type":"StubType"}',
        ];

        yield 'Id is set' => [
            'some-id',
            [],
            '{"@context":"http://schema.org","@type":"StubType","@id":"some-id"}',
        ];

        yield 'Value is an empty string' => [
            null,
            [
                'empty-string' => '',
            ],
            '{"@context":"http://schema.org","@type":"StubType"}',
        ];

        yield 'Value is a string' => [
            null,
            [
                'some-string' => 'some string value',
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-string":"some string value"}',
        ];

        yield 'Value is the number 1 as integer' => [
            null,
            [
                'some-number' => 1,
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-number":"1"}',
        ];

        yield 'Value is the number 0 as integer' => [
            null,
            [
                'some-number' => 0,
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-number":"0"}',
        ];

        yield 'Value is the number 0.10 as float' => [
            null,
            [
                'some-number' => 0.10,
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-number":"0.1"}',
        ];

        yield 'Value is the number 0.00 as float' => [
            null,
            [
                'some-number' => 0.00,
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-number":"0"}',
        ];

        yield 'Value is a boolean (true)' => [
            null,
            [
                'some-boolean-true' => true,
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-boolean-true":"http://schema.org/True"}',
        ];

        yield 'Value is a boolean (false)' => [
            null,
            [
                'some-boolean-false' => false,
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-boolean-false":"http://schema.org/False"}',
        ];

        yield 'Value is an empty array' => [
            null,
            [
                'empty-array' => [],
            ],
            '{"@context":"http://schema.org","@type":"StubType"}',
        ];

        yield 'Value is an array of strings' => [
            null,
            [
                'some-array' => [
                    'some-array-value',
                    'another-array-value',
                ],
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-array":["some-array-value","another-array-value"]}',
        ];

        yield 'Value is a model' => [
            null,
            [
                'some-type' => $this->createTypeStub(
                    'from-type-property',
                    ['some-property' => 'some-value'],
                    'SomeSubTypeStub'
                ),
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-type":{"@type":"SomeSubTypeStub","@id":"from-type-property","some-property":"some-value"}}',
        ];

        yield 'Value is an array of models' => [
            null,
            [
                'some-type' => [
                    $this->createTypeStub(
                        'from-type-property',
                        ['some-property' => 'some-value'],
                        'SomeSubTypeStub'
                    ),
                    $this->createTypeStub(
                        'from-another-type-property',
                        ['another-property' => 'another-value'],
                        'AnotherSubTypeStub'
                    ),
                ],
            ],
            '{"@context":"http://schema.org","@type":"StubType","some-type":[{"@type":"SomeSubTypeStub","@id":"from-type-property","some-property":"some-value"},{"@type":"AnotherSubTypeStub","@id":"from-another-type-property","another-property":"another-value"}]}',
        ];
    }

    private function createTypeStub(
        ?string $id = null,
        array $properties = [],
        string $type = 'StubType'
    ): TypeInterface {
        return new class($id, $properties, $type) implements TypeInterface {
            private $id;
            private $properties;
            private $type;

            public function __construct(?string $id, array $properties, string $type)
            {
                $this->id = $id;
                $this->properties = $properties;
                $this->type = $type;
            }

            public function getId(): ?string
            {
                return $this->id;
            }

            public function setId(string $id)
            {
            }

            public function hasProperty(string $propertyName): bool
            {
                return true;
            }

            public function getProperty(string $propertyName)
            {
                return $this->properties[$propertyName];
            }

            public function setProperty(string $propertyName, $propertyValue)
            {
            }

            public function addProperty(string $propertyName, $propertyValue)
            {
            }

            public function setProperties(array $properties)
            {
            }

            public function clearProperty(string $propertyName)
            {
            }

            public function getPropertyNames(): array
            {
                return \array_keys($this->properties);
            }

            public function getType(): string
            {
                return $this->type;
            }
        };
    }

    /**
     * @test
     */
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedSeparately(): void
    {
        $this->subject->addType($this->createTypeStub('some-id'));
        $this->subject->addType($this->createTypeStub('another-id'));

        self::assertSame(
            \sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"http://schema.org","@graph":[{"@type":"StubType","@id":"some-id"},{"@type":"StubType","@id":"another-id"}]}'
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
            $this->createTypeStub('some-id'),
            $this->createTypeStub('another-id'),
        ];

        $this->subject->addType(...$types);

        self::assertSame(
            \sprintf(
                Extension::JSONLD_TEMPLATE,
                '{"@context":"http://schema.org","@graph":[{"@type":"StubType","@id":"some-id"},{"@type":"StubType","@id":"another-id"}]}'
            ),
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function clearTypesRemovesAllTypes(): void
    {
        $this->subject->addType($this->createTypeStub('some-id'));
        $this->subject->clearTypes();

        self::assertSame('', $this->subject->render());
    }
}
