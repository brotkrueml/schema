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
    protected $alternateName;
    protected $identifier;
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
        $this->concreteType->setProperty('name', 'Pi');
        $this->concreteType->setProperty('description', ['The answert for everything']);
        $this->concreteType->setProperty('identifier', 42);
        $this->concreteType->setProperty('alternateName', 3.141592653);

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
    public function addPropertyAcceptsValidDataTypesAsValue(): void
    {
        $this->concreteType->setProperty('name', 'Pi');
        $this->concreteType->setProperty('description', ['The answert for everything']);
        $this->concreteType->addProperty('identifier', 42);
        $this->concreteType->addProperty('alternateName', 3.141592653);

        $anotherConcreteType = new class extends AbstractType {
        };

        $this->concreteType->addProperty('image', $anotherConcreteType);

        // Assertion is valid, when no exception above is thrown
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function setPropertiesReturnsReferenceToItself(): void
    {
        $actual = $this->concreteType->setProperties([]);

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertiesSetsThePropertiesCorrectly(): void
    {
        $this->concreteType->setProperties([
            'name' => 'some name',
            'description' => 'some description',
            'image' => ['some image value', 'other image value'],
        ]);

        $actualName = $this->concreteType->getProperty('name');

        $this->assertSame('some name', $actualName);

        $actualDescription = $this->concreteType->getProperty('description');

        $this->assertSame('some description', $actualDescription);

        $actualImage = $this->concreteType->getProperty('image');

        $this->assertSame(['some image value', 'other image value'], $actualImage);
    }

    /**
     * @test
     */
    public function clearPropertySetsValueToNull(): void
    {
        $resultOfClear = $this->concreteType
            ->setProperty('image', 'some image value')
            ->clearProperty('image');

        $this->assertInstanceOf(AbstractType::class, $resultOfClear);

        $resultOfGet = $this->concreteType
            ->getProperty('image');

        $this->assertNull($resultOfGet);
    }

    /**
     * @test
     */
    public function clearPropertyThrowsDomainExceptionIfPropertyNameDoesNotExist(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1561829996);

        $this->concreteType->clearProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function getPropertiesReturnsListOfAllProperties(): void
    {
        $actual = $this->concreteType->getProperties();

        $this->assertSame(
            [
                'alternateName',
                'description',
                'identifier',
                'image',
                'name',
                'url',
            ],
            $actual
        );
    }

    /**
     * @test
     */
    public function isEmptyReturnsTrueOnNewlyCreatedModel(): void
    {
        $actual = $this->concreteType->isEmpty();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsFalseIfOnePropertyHasStringValue(): void
    {
        $this->concreteType->setProperty('name', 'some name');

        $actual = $this->concreteType->isEmpty();

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsTrueWithPropertiesSetToEmptyValues(): void
    {
        $this->concreteType
            ->setProperty('name', '')
            ->setProperty('description', []);

        $actual = $this->concreteType->isEmpty();

        $this->assertTrue($actual);
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
            'Value is a number as string' => [
                'name',
                '1',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'name' => '1',
                ],
            ],
            'Value is a number as integer' => [
                'name',
                1,
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'name' => '1',
                ],
            ],
            'Value is the number 0 as integer' => [
                'name',
                0,
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                    'name' => '0',
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
            'value is null' => [
                'image',
                null,
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
                ],
            ],
            'value is an empty string' => [
                'image',
                '',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'ConcreteType',
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
    public function toArrayReturnsCorrectResultWhenNoPropertiesAreSet(): void
    {
        $actual = $this->concreteType->toArray();

        $this->assertSame(['@context' => 'http://schema.org', '@type' => 'ConcreteType'], $actual);
    }
}
