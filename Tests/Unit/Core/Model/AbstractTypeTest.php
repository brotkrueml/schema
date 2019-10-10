<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\Model;

use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureImage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use PHPUnit\Framework\TestCase;

class AbstractTypeTest extends TestCase
{
    /**
     * @var AbstractType
     */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = new FixtureThing();
    }

    /**
     * @test
     */
    public function setIdReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->subject->setId('concreteTestId');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function getIdReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->subject->getId();

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getIdReturnsTheIdCorrectly(): void
    {
        $this->subject->setId('concreteTestId');

        $actual = $this->subject->getId();

        $this->assertSame('concreteTestId', $actual);
    }

    /**
     * @test
     */
    public function hasPropertyReturnsTrueIfPropertyExists(): void
    {
        $this->assertTrue(
            $this->subject->hasProperty('name')
        );
    }

    /**
     * @test
     */
    public function hasPropertyReturnsFalseIfPropertyDoesNotExists(): void
    {
        $this->assertFalse(
            $this->subject->hasProperty('propertyDoesNotExist')
        );
    }

    /**
     * @test
     */
    public function setPropertyReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->subject->setProperty('name', 'the name');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertyAcceptsValidDataTypesAsValue(): void
    {
        $this->subject->setProperty('name', 'Pi');
        $this->subject->setProperty('description', ['The answert for everything']);
        $this->subject->setProperty('identifier', 42);
        $this->subject->setProperty('alternateName', 3.141592653);

        $anotherType = new class extends AbstractType {
        };

        $this->subject->setProperty('image', $anotherType);

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

        $this->subject->setProperty('invalidProperty', 'some value');
    }

    /**
     * @test
     */
    public function setPropertyThrowsInvalidArgumentExceptionIfPropertyNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1561830012);

        $this->subject->setProperty('image', new \stdClass());
    }

    /**
     * @test
     */
    public function getPropertyReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->subject->getProperty('name');

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getPropertyReturnsCorrectValue(): void
    {
        $actual = $this->subject
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

        $this->subject->getProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function addPropertyForNotAlreadySetProperty(): void
    {
        $actual = $this->subject
            ->addProperty('name', 'the test name')
            ->getProperty('name');

        $this->assertSame('the test name', $actual);
    }

    /**
     * @test
     */
    public function addPropertyForPropertyWithStringAlreadySet(): void
    {
        $actual = $this->subject
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
        $actual = $this->subject
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
        $this->subject->setProperty('name', 'Pi');
        $this->subject->setProperty('description', ['The answert for everything']);
        $this->subject->addProperty('identifier', 42);
        $this->subject->addProperty('alternateName', 3.141592653);

        $anotherType = new class extends AbstractType {
        };

        $this->subject->addProperty('image', $anotherType);

        // Assertion is valid, when no exception above is thrown
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function setPropertiesReturnsReferenceToItself(): void
    {
        $actual = $this->subject->setProperties([]);

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertiesSetsThePropertiesCorrectly(): void
    {
        $this->subject->setProperties([
            'name' => 'some name',
            'description' => 'some description',
            'image' => ['some image value', 'other image value'],
        ]);

        $actualName = $this->subject->getProperty('name');

        $this->assertSame('some name', $actualName);

        $actualDescription = $this->subject->getProperty('description');

        $this->assertSame('some description', $actualDescription);

        $actualImage = $this->subject->getProperty('image');

        $this->assertSame(['some image value', 'other image value'], $actualImage);
    }

    /**
     * @test
     */
    public function clearPropertySetsValueToNull(): void
    {
        $resultOfClear = $this->subject
            ->setProperty('image', 'some image value')
            ->clearProperty('image');

        $this->assertInstanceOf(AbstractType::class, $resultOfClear);

        $resultOfGet = $this->subject
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

        $this->subject->clearProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function getPropertiesReturnsListOfAllProperties(): void
    {
        $actual = $this->subject->getPropertyNames();

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
        $actual = $this->subject->isEmpty();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsFalseIfOnePropertyHasStringValue(): void
    {
        $this->subject->setProperty('name', 'some name');

        $actual = $this->subject->isEmpty();

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsTrueWithPropertiesSetToEmptyValues(): void
    {
        $this->subject
            ->setProperty('name', '')
            ->setProperty('description', []);

        $actual = $this->subject->isEmpty();

        $this->assertTrue($actual);
    }

    public function dataProviderForToArrayReturnsCorrectResult(): iterable
    {
        yield 'Value is a string' => [
            'name',
            'some string value',
            [
                '@type' => 'FixtureThing',
                'name' => 'some string value',
            ],
        ];

        yield 'Value is a number as string' => [
        'name',
        '1',
        [
            '@type' => 'FixtureThing',
            'name' => '1',
        ],
    ];

        yield 'Value is a number as integer' => [
            'name',
            1,
            [
                '@type' => 'FixtureThing',
                'name' => '1',
            ],
        ];

        yield 'Value is the number 0 as integer' => [
            'name',
            0,
            [
                '@type' => 'FixtureThing',
                'name' => '0',
            ],
        ];

        yield 'Value is a model' => [
            'image',
            (new FixtureImage())
                ->setProperty('name', 'some value for name'),
            [
                '@type' => 'FixtureThing',
                'image' => [
                    '@type' => 'FixtureImage',
                    'name' => 'some value for name',
                ],
            ],
        ];

        yield 'Value is an array of models' => [
            'image',
            [
                (new FixtureImage())
                    ->setProperty('name', 'some value for name'),
                (new FixtureImage())
                    ->setProperty('description', 'some value for description'),
            ],
            [
                '@type' => 'FixtureThing',
                'image' => [
                    [
                        '@type' => 'FixtureImage',
                        'name' => 'some value for name',
                    ],
                    [
                        '@type' => 'FixtureImage',
                        'description' => 'some value for description',
                    ],
                ],
            ],
        ];

        yield 'Value is an array of strings' => [
            'image',
            ['the first string', 'the second string'],
            [
                '@type' => 'FixtureThing',
                'image' => [
                    'the first string',
                    'the second string',
                ],
            ],
        ];

        yield 'Value is an array of a string and a model' => [
            'image',
            [
                'the first string',
                (new FixtureImage())
                    ->setProperty('name', 'some value for image'),
            ],
            [
                '@type' => 'FixtureThing',
                'image' => [
                    'the first string',
                    [
                        '@type' => 'FixtureImage',
                        'name' => 'some value for image',
                    ],
                ],
            ],
        ];

        yield 'value is null' => [
            'image',
            null,
            [
                '@type' => 'FixtureThing',
            ],
        ];

        yield 'value is an empty string' => [
            'image',
            '',
            [
                '@type' => 'FixtureThing',
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
        $actual = $this->subject
            ->setProperty($key, $value)
            ->toArray();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function toArrayReturnsCorrectResultWhenNoPropertiesAreSet(): void
    {
        $actual = $this->subject->toArray();

        $this->assertSame(['@type' => 'FixtureThing'], $actual);
    }
}
