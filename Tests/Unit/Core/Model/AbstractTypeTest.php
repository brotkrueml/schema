<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\Model;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;

trait ConcreteTypeTraitA
{
    protected $name;
    protected $url;
}

trait ConcreteTypeTraitB
{
    protected $name;
    protected $description;
    protected $image;
}

/**
 * @property string name
 */
class ConcreteType extends AbstractType
{
    use ConcreteTypeTraitA;
    use ConcreteTypeTraitB;
}

class AbstractTypeTest extends TestCase
{
    /**
     * @var AbstractType
     */
    protected $concreteType;

    public function setUp(): void
    {
        $this->concreteType = new ConcreteType();
    }

    /**
     * @test
     */
    public function setIdReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->concreteType->setId('concreteTestId');

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
        $this->concreteType->setId('concreteTestId');

        $actual = $this->concreteType->getId();

        $this->assertSame('concreteTestId', $actual);
    }

    /**
     * @test
     */
    public function hasPropertyReturnsTrueIfPropertyExists(): void
    {
        $this->assertTrue(
            $this->concreteType->hasProperty('name')
        );
    }

    /**
     * @test
     */
    public function hasPropertyReturnsFalseIfPropertyDoesNotExists(): void
    {
        $this->assertFalse(
            $this->concreteType->hasProperty('propertyDoesNotExist')
        );
    }

    /**
     * @test
     */
    public function setPropertyReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->concreteType->setProperty('name', 'the name');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertyAcceptsValidDataTypesAsValue(): void
    {
        $this->concreteType->setProperty('name', 'some test name');
        $this->concreteType->setProperty('description', ['some test description as array']);

        $anotherConcreteType = new class extends AbstractType {
        };

        $this->concreteType->setProperty('image', $anotherConcreteType);

        // Assertion is valid, when no exception above is thrown
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function setPropertyThrowsDomainExceptionIfPropertyNameNotValid(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1561829996);

        $this->concreteType->setProperty('invalidProperty', 'some value');
    }

    /**
     * @test
     */
    public function setPropertyThrowsInvalidArgumentExceptionIfPropertyNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1561830012);

        $this->concreteType->setProperty('image', new \stdClass());
    }

    /**
     * @test
     */
    public function getPropertyReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->concreteType->getProperty('name');

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getPropertyReturnsCorrectValue(): void
    {
        $actual = $this->concreteType
            ->setProperty('image', ['some image value', 'another image value'])
            ->getProperty('image');

        $this->assertSame(['some image value', 'another image value'], $actual);
    }

    /**
     * @test
     */
    public function getPropertyThrowsDomainExceptionIfPropertyNameDoesNotExist(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1561829996);

        $this->concreteType->getProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function addPropertyForNotAlreadySetProperty(): void
    {
        $actual = $this->concreteType
            ->addProperty('name', 'the test name')
            ->getProperty('name');

        $this->assertSame('the test name', $actual);
    }

    /**
     * @test
     */
    public function addPropertyForPropertyWithStringAlreadySet(): void
    {
        $actual = $this->concreteType
            ->setProperty('image', 'first image element')
            ->addProperty('image', 'second image element')
            ->getProperty('image');

        $this->assertSame(['first image element', 'second image element'], $actual);
    }

    /**
     * @test
     */
    public function addPropertyForPropertyWithArrayAlreadySet(): void
    {
        $actual = $this->concreteType
            ->setProperty('image', ['some image value'])
            ->addProperty('image', 'other image value')
            ->getProperty('image');

        $this->assertSame(['some image value', 'other image value'], $actual);
    }

    /**
     * @test
     */
    public function getPropertiesReturnsListOfAllProperties(): void
    {
        $actual = $this->concreteType->getProperties();

        $this->assertSame(
            [
                'description',
                'image',
                'name',
                'url',
            ],
            $actual
        );
    }

    public function dataProviderForToArrayReturnsCorrectResult(): array
    {
        $anotherConcreteType = new class extends AbstractType {
            use ConcreteTypeTraitB;

            protected function getType(): string
            {
                return 'AnotherConcreteType';
            }
        };

        /** @noinspection PhpUndefinedMethodInspection */
        return [
            'Value is a string' => [
                'name',
                'some string value',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'name' => 'some string value',
                ],
            ],
            'Value is a model' => [
                'image',
                (new $anotherConcreteType())
                    ->setProperty('name', 'some value for name'),
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'image' => [
                        '@type' => 'AnotherConcreteType',
                        'name' => 'some value for name',
                    ],
                ],
            ],
            'Value is an array of models' => [
                'image',
                [
                    (new $anotherConcreteType())
                        ->setProperty('name', 'some value for name'),
                    (new $anotherConcreteType())
                        ->setProperty('description', 'some value for description'),
                ],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'image' => [
                        [
                            '@type' => 'AnotherConcreteType',
                            'name' => 'some value for name',
                        ],
                        [
                            '@type' => 'AnotherConcreteType',
                            'description' => 'some value for description',
                        ],
                    ],
                ],
            ],
            'Value is an array of strings' => [
                'image',
                ['the first string', 'the second string'],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'image' => [
                        'the first string',
                        'the second string',
                    ],
                ],
            ],
            'Value is an array of a string and a model' => [
                'image',
                [
                    'the first string',
                    (new $anotherConcreteType())
                        ->setProperty('name', 'some value for image'),
                ],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'image' => [
                        'the first string',
                        [
                            '@type' => 'AnotherConcreteType',
                            'name' => 'some value for image',
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
