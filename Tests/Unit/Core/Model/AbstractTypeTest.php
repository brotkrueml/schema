<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\Model;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureImage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use PHPUnit\Framework\TestCase;

class AbstractTypeTest extends TestCase
{
    /**
     * @var AbstractType
     */
    protected $fixtureType;

    public function setUp(): void
    {
        $this->fixtureType = new FixtureThing();
    }

    /**
     * @test
     */
    public function setIdReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->fixtureType->setId('concreteTestId');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function getIdReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->fixtureType->getId();

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getIdReturnsTheIdCorrectly(): void
    {
        $this->fixtureType->setId('concreteTestId');

        $actual = $this->fixtureType->getId();

        $this->assertSame('concreteTestId', $actual);
    }

    /**
     * @test
     */
    public function hasPropertyReturnsTrueIfPropertyExists(): void
    {
        $this->assertTrue(
            $this->fixtureType->hasProperty('name')
        );
    }

    /**
     * @test
     */
    public function hasPropertyReturnsFalseIfPropertyDoesNotExists(): void
    {
        $this->assertFalse(
            $this->fixtureType->hasProperty('propertyDoesNotExist')
        );
    }

    /**
     * @test
     */
    public function setPropertyReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->fixtureType->setProperty('name', 'the name');

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertyAcceptsValidDataTypesAsValue(): void
    {
        $this->fixtureType->setProperty('name', 'Pi');
        $this->fixtureType->setProperty('description', ['The answert for everything']);
        $this->fixtureType->setProperty('identifier', 42);
        $this->fixtureType->setProperty('alternateName', 3.141592653);

        $anotherType = new class extends AbstractType {
        };

        $this->fixtureType->setProperty('image', $anotherType);

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

        $this->fixtureType->setProperty('invalidProperty', 'some value');
    }

    /**
     * @test
     */
    public function setPropertyThrowsInvalidArgumentExceptionIfPropertyNotValid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1561830012);

        $this->fixtureType->setProperty('image', new \stdClass());
    }

    /**
     * @test
     */
    public function getPropertyReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->fixtureType->getProperty('name');

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function getPropertyReturnsCorrectValue(): void
    {
        $actual = $this->fixtureType
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

        $this->fixtureType->getProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function addPropertyForNotAlreadySetProperty(): void
    {
        $actual = $this->fixtureType
            ->addProperty('name', 'the test name')
            ->getProperty('name');

        $this->assertSame('the test name', $actual);
    }

    /**
     * @test
     */
    public function addPropertyForPropertyWithStringAlreadySet(): void
    {
        $actual = $this->fixtureType
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
        $actual = $this->fixtureType
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
        $this->fixtureType->setProperty('name', 'Pi');
        $this->fixtureType->setProperty('description', ['The answert for everything']);
        $this->fixtureType->addProperty('identifier', 42);
        $this->fixtureType->addProperty('alternateName', 3.141592653);

        $anotherType = new class extends AbstractType {
        };

        $this->fixtureType->addProperty('image', $anotherType);

        // Assertion is valid, when no exception above is thrown
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function setPropertiesReturnsReferenceToItself(): void
    {
        $actual = $this->fixtureType->setProperties([]);

        $this->assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertiesSetsThePropertiesCorrectly(): void
    {
        $this->fixtureType->setProperties([
            'name' => 'some name',
            'description' => 'some description',
            'image' => ['some image value', 'other image value'],
        ]);

        $actualName = $this->fixtureType->getProperty('name');

        $this->assertSame('some name', $actualName);

        $actualDescription = $this->fixtureType->getProperty('description');

        $this->assertSame('some description', $actualDescription);

        $actualImage = $this->fixtureType->getProperty('image');

        $this->assertSame(['some image value', 'other image value'], $actualImage);
    }

    /**
     * @test
     */
    public function clearPropertySetsValueToNull(): void
    {
        $resultOfClear = $this->fixtureType
            ->setProperty('image', 'some image value')
            ->clearProperty('image');

        $this->assertInstanceOf(AbstractType::class, $resultOfClear);

        $resultOfGet = $this->fixtureType
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

        $this->fixtureType->clearProperty('invalidPropertyName');
    }

    /**
     * @test
     */
    public function getPropertiesReturnsListOfAllProperties(): void
    {
        $actual = $this->fixtureType->getPropertyNames();

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
        $actual = $this->fixtureType->isEmpty();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsFalseIfOnePropertyHasStringValue(): void
    {
        $this->fixtureType->setProperty('name', 'some name');

        $actual = $this->fixtureType->isEmpty();

        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsTrueWithPropertiesSetToEmptyValues(): void
    {
        $this->fixtureType
            ->setProperty('name', '')
            ->setProperty('description', []);

        $actual = $this->fixtureType->isEmpty();

        $this->assertTrue($actual);
    }

    public function dataProviderForToArrayReturnsCorrectResult(): array
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return [
            'Value is a string' => [
                'name',
                'some string value',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
                    'name' => 'some string value',
                ],
            ],
            'Value is a number as string' => [
                'name',
                '1',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
                    'name' => '1',
                ],
            ],
            'Value is a number as integer' => [
                'name',
                1,
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
                    'name' => '1',
                ],
            ],
            'Value is the number 0 as integer' => [
                'name',
                0,
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
                    'name' => '0',
                ],
            ],
            'Value is a model' => [
                'image',
                (new FixtureImage())
                    ->setProperty('name', 'some value for name'),
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
                    'image' => [
                        '@type' => 'FixtureImage',
                        'name' => 'some value for name',
                    ],
                ],
            ],
            'Value is an array of models' => [
                'image',
                [
                    (new FixtureImage())
                        ->setProperty('name', 'some value for name'),
                    (new FixtureImage())
                        ->setProperty('description', 'some value for description'),
                ],
                [
                    '@context' => 'http://schema.org',
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
            ],
            'Value is an array of strings' => [
                'image',
                ['the first string', 'the second string'],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
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
                    (new FixtureImage())
                        ->setProperty('name', 'some value for image'),
                ],
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
                    'image' => [
                        'the first string',
                        [
                            '@type' => 'FixtureImage',
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
                    '@type' => 'FixtureThing',
                ],
            ],
            'value is an empty string' => [
                'image',
                '',
                [
                    '@context' => 'http://schema.org',
                    '@type' => 'FixtureThing',
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
        $actual = $this->fixtureType
            ->setProperty($key, $value)
            ->toArray();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function toArrayReturnsCorrectResultWhenNoPropertiesAreSet(): void
    {
        $actual = $this->fixtureType->toArray();

        $this->assertSame(['@context' => 'http://schema.org', '@type' => 'FixtureThing'], $actual);
    }
}
