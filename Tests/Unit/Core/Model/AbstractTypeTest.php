<?php
declare (strict_types=1);

namespace Brotkrueml\Schema\Core\Model;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

class AbstractTypeTest extends TestCase
{
    /**
     * @var AbstractType
     */
    protected $concreteType;

    public function setUp(): void
    {
        $this->concreteType = new class extends AbstractType
        {
            public function __construct()
            {
                parent::__construct();

                $this->addProperties(
                    'foo',
                    'bar',
                    'baz'
                );
            }

            protected function getType(): string
            {
                return 'SomeType';
            }
        };
    }

    /**
     * @test
     */
    public function setIdReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->concreteType->setId('someTestId');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function getIdReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->concreteType->getId();

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getIdReturnsTheIdCorrectly(): void
    {
        $this->concreteType->setId('someFooBar');

        $actual = $this->concreteType->getId();

        $this->assertSame('someFooBar', $actual);
    }

    /**
     * @test
     */
    public function hasPropertyReturnsTrueIfPropertyExists(): void
    {
        $this->assertTrue(
            $this->concreteType->hasProperty('foo')
        );
    }

    /**
     * @test
     */
    public function hasPropertyReturnsFalseIfPropertyDoesNotExists(): void
    {
        $this->assertFalse(
            $this->concreteType->hasProperty('foobar')
        );
    }

    /**
     * @test
     */
    public function setPropertyReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->concreteType->setProperty('foo', 'some property value');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertyAcceptsValidDataTypesAsValue(): void
    {
        $this->concreteType->setProperty('foo', 'someString');
        $this->concreteType->setProperty('bar', ['some array']);

        $anotherConcreteType = new class extends AbstractType
        {
        };

        $this->concreteType->setProperty('baz', $anotherConcreteType);

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function setPropertyThrowsDomainExceptionIfPropertyNameNotValid(): void
    {
        $this->expectException(\DomainException::class);

        $this->concreteType->setProperty('invalidProperty', 'some value');
    }

    /**
     * @test
     */
    public function setPropertyThrowsInvalidArgumentExceptionIfPropertyNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->concreteType->setProperty('foo', new \stdClass());
    }

    /**
     * @test
     */
    public function getPropertyReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->concreteType->getProperty('foo');

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getPropertyReturnsCorrectValue(): void
    {
        $actual = $this->concreteType
            ->setProperty('foo', ['some array value', 'another array value'])
            ->getProperty('foo');

        $this->assertSame(['some array value', 'another array value'], $actual);
    }

    /**
     * @test
     */
    public function getPropertyThrowsDomainExceptionIfPropertyNameDoesNotExist(): void
    {
        $this->expectException(\DomainException::class);

        $this->concreteType->getProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function addPropertyForNotAlreadySetProperty(): void
    {
        $actual = $this->concreteType
            ->addProperty('foo', 'something')
            ->getProperty('foo');

        $this->assertSame('something', $actual);
    }

    /**
     * @test
     */
    public function addPropertyForPropertyWithStringAlreadySet(): void
    {
        $actual = $this->concreteType
            ->setProperty('foo', 'first element')
            ->addProperty('foo', 'second element')
            ->getProperty('foo');

        $this->assertSame(['first element', 'second element'], $actual);
    }

    /**
     * @test
     */
    public function addPropertyForPropertyWithArrayAlreadySet(): void
    {
        $actual = $this->concreteType
            ->setProperty('foo', ['some array value'])
            ->addProperty('foo', 'some other value')
            ->getProperty('foo');

        $this->assertSame([['some array value'], 'some other value'], $actual);
    }


    public function dataProviderForToArrayReturnsCorrectResult(): array
    {
        $anotherConcreteType = new class extends AbstractType
        {
            public function __construct()
            {
                parent::__construct();

                $this->addProperties('property1', 'property2');
            }

            protected function getType(): string
            {
                return 'SomeOtherType';
            }
        };

        /** @noinspection PhpUndefinedMethodInspection */
        return [
            'Value is a string' => [
                'foo',
                'some string value',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'SomeType',
                    'foo' => 'some string value',
                ],
            ],
            'Value is a model' => [
                'foo',
                (new $anotherConcreteType())
                    ->setProperty('property1', 'some value for property 1'),
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'SomeType',
                    'foo' => [
                        '@type' => 'SomeOtherType',
                        'property1' => 'some value for property 1',
                    ],
                ],
            ],
            'Value is an array of models' => [
                'foo',
                [
                    (new $anotherConcreteType())
                        ->setProperty('property1', 'some value for property 1'),
                    (new $anotherConcreteType())
                        ->setProperty('property2', 'some value for property 2'),
                ],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'SomeType',
                    'foo' => [
                        [
                            '@type' => 'SomeOtherType',
                            'property1' => 'some value for property 1',
                        ],
                        [
                            '@type' => 'SomeOtherType',
                            'property2' => 'some value for property 2',
                        ],
                    ],
                ],
            ],
            'Value is an array of strings' => [
                'foo',
                ['the first string', 'the second string'],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'SomeType',
                    'foo' => [
                        'the first string',
                        'the second string',
                    ],
                ],
            ],
            'Value is an array of a string and a model' => [
                'foo',
                [
                    'the first string',
                    (new $anotherConcreteType())
                        ->setProperty('property1', 'some value for property 1'),
                ],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'SomeType',
                    'foo' => [
                        'the first string',
                        [
                            '@type' => 'SomeOtherType',
                            'property1' => 'some value for property 1',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForToArrayReturnsCorrectResult
     * @param string $key
     * @param string|array|AbstractType $value
     * @param array $expected
     */
    public function toArrayReturnsCorrectResult(string $key, $value, array $expected): void
    {
        $actual = $this->concreteType
            ->setProperty($key, $value)
            ->toArray();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function toArrayReturnsEmptyArrayIfNoContentIsAvailable(): void
    {
        $actual = $this->concreteType->toArray();

        $this->assertSame([], $actual);
    }
}
