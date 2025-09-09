<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\AdditionalPropertiesInterface;
use Brotkrueml\Schema\Core\Exception\InvalidPropertyValueException;
use Brotkrueml\Schema\Core\Exception\UnknownPropertyException;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\Model\EnumerationInterface;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\_3DModel;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\ThingWithResolvedTypesExposed;
use Brotkrueml\Schema\Type\AdditionalPropertiesProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractType::class)]
final class AbstractTypeTest extends TestCase
{
    protected Thing $subject;

    protected function setUp(): void
    {
        $this->subject = new Thing(new AdditionalPropertiesProvider());
    }

    #[Test]
    public function subjectImplementsTypeInterface(): void
    {
        self::assertInstanceOf(TypeInterface::class, $this->subject);
    }

    #[Test]
    public function subjectImplementsNodeIdentifierInterface(): void
    {
        self::assertInstanceOf(NodeIdentifierInterface::class, $this->subject);
    }

    #[Test]
    public function additionalPropertiesAreAvailable(): void
    {
        $additionalProperties = new class implements AdditionalPropertiesInterface {
            public function getType(): string
            {
                return 'Thing';
            }

            public function getAdditionalProperties(): array
            {
                return [
                    'someAdditionalProperty',
                    'anotherAdditionalProperty',
                ];
            }
        };
        $additionalPropertiesProvider = new AdditionalPropertiesProvider();
        $additionalPropertiesProvider->add($additionalProperties::class);

        $subject = new Thing($additionalPropertiesProvider);

        self::assertTrue($subject->hasProperty('name'), 'initially defined property is available');
        self::assertTrue($subject->hasProperty('someAdditionalProperty'), 'added property is available');
        self::assertTrue($subject->hasProperty('anotherAdditionalProperty'), 'added property is available');
    }

    #[Test]
    public function propertiesAreSortedAlphabeticallyAfterAddingAdditionalProperties(): void
    {
        $additionalProperties = new class implements AdditionalPropertiesInterface {
            public function getType(): string
            {
                return 'Thing';
            }

            public function getAdditionalProperties(): array
            {
                return [
                    'someAdditionalProperty',
                    'anotherAdditionalProperty',
                ];
            }
        };
        $additionalPropertiesProvider = new AdditionalPropertiesProvider();
        $additionalPropertiesProvider->add($additionalProperties::class);

        $subject = new Thing($additionalPropertiesProvider);

        $indexOfSomeAdditionalProperty = \array_search('someAdditionalProperty', $subject->getPropertyNames());
        $indexOfAnotherAdditionalProperty = \array_search('anotherAdditionalProperty', $subject->getPropertyNames());
        $indexOfName = \array_search('name', $subject->getPropertyNames());

        self::assertLessThan($indexOfName, $indexOfAnotherAdditionalProperty);
        self::assertLessThan($indexOfSomeAdditionalProperty, $indexOfName);
    }

    #[Test]
    public function getIdReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->subject->getId();

        self::assertNull($actual);
    }

    #[Test]
    public function getIdReturnsTheIdCorrectlyWhenSetPreviouslyWithNull(): void
    {
        $this->subject->setId(null);

        self::assertNull($this->subject->getId());
    }

    #[Test]
    public function getIdReturnsNullWhenSetPreviouslyWithEmptyString(): void
    {
        $this->subject->setId('');

        self::assertNull($this->subject->getId());
    }

    #[Test]
    public function getIdReturnsTheIdCorrectlyWhenSetPreviouslyWithAString(): void
    {
        $this->subject->setId('concreteTestId');

        self::assertSame('concreteTestId', $this->subject->getId());
    }

    #[Test]
    public function getIdReturnsTheIdAsStringWhenSetPreviouslyWithANodeIdentifier(): void
    {
        $this->subject->setId(new class implements NodeIdentifierInterface {
            public function getId(): string
            {
                return 'someNodeIdentifier';
            }
        });

        self::assertSame('someNodeIdentifier', $this->subject->getId());
    }

    #[Test]
    public function hasPropertyReturnsTrueIfPropertyExists(): void
    {
        self::assertTrue(
            $this->subject->hasProperty('name'),
        );
    }

    #[Test]
    public function hasPropertyReturnsFalseIfPropertyDoesNotExists(): void
    {
        self::assertFalse(
            $this->subject->hasProperty('propertyDoesNotExist'),
        );
    }

    #[Test]
    public function setPropertyReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->subject->setProperty('name', 'the name');

        self::assertInstanceOf(AbstractType::class, $actual);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function setPropertyAcceptsValidDataTypesAsValue(): void
    {
        // Test is valid, when no exception is thrown
        $this->subject->setProperty('name', 'Pi');
        $this->subject->setProperty('description', ['The answer for everything']);
        $this->subject->setProperty('identifier', 42);
        $this->subject->setProperty('alternateName', 3.141592653);
        $this->subject->setProperty('image', new GenericStub());
        $this->subject->setProperty('subjectOf', new class implements NodeIdentifierInterface {
            public function getId(): string
            {
                return 'some-node-identifier';
            }
        });
        $this->subject->setProperty('isAccessibleForFree', new class implements EnumerationInterface {
            public function canonical(): string
            {
                return 'some-canonical';
            }
        });
    }

    #[Test]
    public function setPropertyThrowsDomainExceptionIfPropertyNameNotValid(): void
    {
        $this->expectException(UnknownPropertyException::class);
        $this->expectExceptionCode(1561829996);

        $this->subject->setProperty('invalidProperty', 'some value');
    }

    #[Test]
    public function setPropertyThrowsInvalidArgumentExceptionIfPropertyNotValid(): void
    {
        $this->expectException(InvalidPropertyValueException::class);
        $this->expectExceptionCode(1561830012);

        $this->subject->setProperty('image', new \stdClass());
    }

    #[Test]
    public function getPropertyReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->subject->getProperty('name');

        self::assertNull($actual);
    }

    #[Test]
    public function getPropertyReturnsCorrectValue(): void
    {
        $actual = $this->subject
            ->setProperty('image', ['some image value', 'another image value'])
            ->getProperty('image');

        self::assertSame(['some image value', 'another image value'], $actual);
    }

    #[Test]
    public function getPropertyThrowsDomainExceptionIfPropertyNameDoesNotExist(): void
    {
        $this->expectException(UnknownPropertyException::class);
        $this->expectExceptionCode(1561829996);

        $this->subject->getProperty('invalidPropertyName');
    }

    #[Test]
    public function addPropertyForNotAlreadySetProperty(): void
    {
        $actual = $this->subject
            ->addProperty('name', 'the test name')
            ->getProperty('name');

        self::assertSame('the test name', $actual);
    }

    #[Test]
    public function addPropertyForPropertyWithStringAlreadySet(): void
    {
        $actual = $this->subject
            ->setProperty('image', 'first image element')
            ->addProperty('image', 'second image element')
            ->getProperty('image');

        self::assertSame(['first image element', 'second image element'], $actual);
    }

    #[Test]
    public function addPropertyForPropertyWithArrayAlreadySet(): void
    {
        $actual = $this->subject
            ->setProperty('image', ['some image value'])
            ->addProperty('image', 'other image value')
            ->getProperty('image');

        self::assertSame(['some image value', 'other image value'], $actual);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsStringsAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->setProperty('name', 'some name');
        $this->subject->setProperty('name', 'another name');
        $this->subject->setProperty('name', 'one more name');
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsArraysAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->setProperty('description', ['some description']);
        $this->subject->setProperty('description', ['another description']);
        $this->subject->setProperty('description', ['one more description']);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsIntegerAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->addProperty('identifier', 1);
        $this->subject->addProperty('identifier', 2);
        $this->subject->addProperty('identifier', 3);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsBooleanAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->addProperty('isAccessibleForFree', true);
        $this->subject->addProperty('isAccessibleForFree', false);
        $this->subject->addProperty('isAccessibleForFree', true);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsFloatAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->addProperty('alternateName', 3.141592653);
        $this->subject->addProperty('alternateName', 3.2);
        $this->subject->addProperty('alternateName', 3.3);
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsTypeAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->addProperty('image', new GenericStub());
        $this->subject->addProperty('image', new GenericStub());
        $this->subject->addProperty('image', new GenericStub());
    }

    #[Test]
    #[DoesNotPerformAssertions]
    public function addPropertyAcceptsNodeIdentifierAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->subject->addProperty('subjectOf', new class implements NodeIdentifierInterface {
            public function getId(): string
            {
                return 'some-node-identifier';
            }
        });
        $this->subject->addProperty('subjectOf', new class implements NodeIdentifierInterface {
            public function getId(): string
            {
                return 'another-node-identifier';
            }
        });
        $this->subject->addProperty('subjectOf', new class implements NodeIdentifierInterface {
            public function getId(): string
            {
                return 'one-more-node-identifier';
            }
        });
    }

    #[Test]
    public function setPropertiesReturnsReferenceToItself(): void
    {
        $actual = $this->subject->setProperties([]);

        self::assertInstanceOf(AbstractType::class, $actual);
    }

    #[Test]
    public function setPropertiesSetsThePropertiesCorrectly(): void
    {
        $this->subject->setProperties([
            'name' => 'some name',
            'description' => 'some description',
            'image' => ['some image value', 'other image value'],
        ]);

        $actualName = $this->subject->getProperty('name');

        self::assertSame('some name', $actualName);

        $actualDescription = $this->subject->getProperty('description');

        self::assertSame('some description', $actualDescription);

        $actualImage = $this->subject->getProperty('image');

        self::assertSame(['some image value', 'other image value'], $actualImage);
    }

    #[Test]
    public function clearPropertySetsValueToNull(): void
    {
        $resultOfClear = $this->subject
            ->setProperty('image', 'some image value')
            ->clearProperty('image');

        self::assertInstanceOf(AbstractType::class, $resultOfClear);

        $resultOfGet = $this->subject
            ->getProperty('image');

        self::assertNull($resultOfGet);
    }

    #[Test]
    public function clearPropertyThrowsDomainExceptionIfPropertyNameDoesNotExist(): void
    {
        $this->expectException(UnknownPropertyException::class);
        $this->expectExceptionCode(1561829996);

        $this->subject->clearProperty('invalidPropertyName');
    }

    #[Test]
    public function getPropertiesReturnsListOfAllProperties(): void
    {
        $actual = $this->subject->getPropertyNames();

        self::assertSame(
            [
                'alternateName',
                'description',
                'identifier',
                'image',
                'isAccessibleForFree',
                'name',
                'subjectOf',
                'url',
            ],
            $actual,
        );
    }

    #[Test]
    public function getTypeReturnsTypeCorrectly(): void
    {
        $type = new GenericStub();

        self::assertSame('GenericStub', $type->getType());
    }

    #[Test]
    public function getTypeReturnsTypeCorrectlyWhenClassNameIsDifferentFromTypeDefinedInAttribute(): void
    {
        $subject = new _3DModel(new AdditionalPropertiesProvider());

        self::assertSame('3DModel', $subject->getType());
    }

    #[Test]
    public function getTypeThrowsExceptionWhenNoTypeAttributeIsDefined(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1697271711);
        $this->expectExceptionMessageMatches('/Type model class "Brotkrueml\\\Schema\\\Core\\\Model\\\AbstractType@anonymous.*" does not define the required attribute "Brotkrueml\\\Schema\\\Attributes\\\Type"\./');

        $subject = new class(new AdditionalPropertiesProvider()) extends AbstractType {};

        $subject->getType();
    }

    #[Test]
    #[RunInSeparateProcess]
    public function getTypeCachesRepetitiveUsedTypes(): void
    {
        $subject = new ThingWithResolvedTypesExposed();

        self::assertSame([], $subject->getResolvedTypes());

        $subject->getType();

        self::assertSame([
            ThingWithResolvedTypesExposed::class => 'Thing',
        ], $subject->getResolvedTypes());
    }
}
