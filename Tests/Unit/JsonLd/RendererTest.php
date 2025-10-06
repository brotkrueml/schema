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
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Tests\Fixtures\Enumeration\GenericEnumeration;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Renderer::class)]
#[RunTestsInSeparateProcesses]
final class RendererTest extends TestCase
{
    private Renderer $subject;

    protected function setUp(): void
    {
        $this->subject = new Renderer();
    }

    #[Test]
    public function renderReturnsEmptyStringWhenNoTypeAdded(): void
    {
        self::assertSame('', $this->subject->render());
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[Test]
    #[DataProvider('dataProvider')]
    public function renderReturnsCorrectOutputWithOneTypeGiven(?string $id, array $properties, string $expected): void
    {
        $this->subject->addType((new GenericStub())->setId($id)->defineProperties($properties));

        self::assertSame($expected, $this->subject->render());
    }

    /**
     * @return \Iterator<array<array<int, mixed>, mixed>>
     */
    public static function dataProvider(): \Iterator
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
                'some-type' => (new GenericStub())
                    ->setId('from-type-property')
                    ->defineProperties(
                        [
                            'some-property' => 'some-value',
                        ],
                    ),
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-type":{"@type":"GenericStub","@id":"from-type-property","some-property":"some-value"}}',
        ];

        yield 'Value is an array of models' => [
            null,
            [
                'some-type' => [
                    (new ProductStub())
                        ->setId('from-type-property')
                        ->defineProperties([
                            'some-property' => 'some-value',
                        ]),
                    (new ServiceStub())
                        ->setId('from-another-type-property')
                        ->defineProperties([
                            'another-property' => 'another-value',
                        ]),
                ],
            ],
            '{"@context":"https://schema.org/","@type":"GenericStub","some-type":[{"@type":"ProductStub","@id":"from-type-property","some-property":"some-value"},{"@type":"ServiceStub","@id":"from-another-type-property","another-property":"another-value"}]}',
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

    #[Test]
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedSeparately(): void
    {
        $this->subject->addType((new GenericStub())->setId('some-id'));
        $this->subject->addType((new GenericStub())->setId('another-id'));

        self::assertSame(
            '{"@context":"https://schema.org/","@graph":[{"@type":"GenericStub","@id":"some-id"},{"@type":"GenericStub","@id":"another-id"}]}',
            $this->subject->render(),
        );
    }

    #[Test]
    public function renderReturnsGraphStructureWhenTwoTypesAreAddedAtOnce(): void
    {
        $types = [
            (new GenericStub())->setId('some-id'),
            (new GenericStub())->setId('another-id'),
        ];

        $this->subject->addType(...$types);

        self::assertSame(
            '{"@context":"https://schema.org/","@graph":[{"@type":"GenericStub","@id":"some-id"},{"@type":"GenericStub","@id":"another-id"}]}',
            $this->subject->render(),
        );
    }

    #[Test]
    public function renderHandlesEnumerationCorrectly(): void
    {
        $type = (new GenericStub())->defineProperties(
            [
                'some-property' => GenericEnumeration::Member1,
                'another-property' => GenericEnumeration::Member2,
            ],
        );

        $this->subject->addType($type);

        self::assertSame(
            '{"@context":"https://schema.org/","@type":"GenericStub","some-property":"https://schema.org/Member1","another-property":"https://schema.org/Member2"}',
            $this->subject->render(),
        );
    }

    #[Test]
    public function clearTypesRemovesAllTypes(): void
    {
        $this->subject->addType(new GenericStub('some-id'));
        $this->subject->clearTypes();

        self::assertSame('', $this->subject->render());
    }
}
