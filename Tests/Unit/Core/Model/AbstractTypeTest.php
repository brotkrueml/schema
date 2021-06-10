<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\_3DModel;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AbstractTypeTest extends TestCase
{
    use SchemaCacheTrait;

    protected Thing $subject;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();
        $this->subject = new Thing();
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @est
     */
    public function subjectImplementsTypeInterface(): void
    {
        self::assertInstanceOf(TypeInterface::class, $this->subject);
    }

    /**
     * @est
     */
    public function subjectImplementsNodeIdentifierInterface(): void
    {
        self::assertInstanceOf(NodeIdentifierInterface::class, $this->subject);
    }

    /**
     * @test
     */
    public function getIdReturnsNullAfterInstantiationOfClass(): void
    {
        $actual = $this->subject->getId();

        self::assertNull($actual);
    }

    /**
     * @test
     */
    public function getIdReturnsTheIdCorrectlyWhenSetPreviouslyWithNull(): void
    {
        $this->subject->setId(null);

        self::assertNull($this->subject->getId());
    }

    /**
     * @test
     */
    public function getIdReturnsNullWhenSetPreviouslyWithEmptyString(): void
    {
        $this->subject->setId('');

        self::assertNull($this->subject->getId());
    }

    /**
     * @test
     */
    public function getIdReturnsTheIdCorrectlyWhenSetPreviouslyWithAString(): void
    {
        $this->subject->setId('concreteTestId');

        self::assertSame('concreteTestId', $this->subject->getId());
    }

    /**
     * @test
     */
    public function getIdReturnsTheIdAsStringWhenSetPreviouslyWithANodeIdentifier(): void
    {
        $this->subject->setId(new class() implements NodeIdentifierInterface {
            public function getId(): ?string
            {
                return 'someNodeIdentifier';
            }
        });

        self::assertSame('someNodeIdentifier', $this->subject->getId());
    }

    /**
     * @test
     */
    public function setIdThrowsExceptionWhenInvalidTypeGiven(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1620654936);
        $this->expectExceptionMessage('Value for id has not a valid data type (given: "bool"). Valid types are: null, string, instanceof NodeIdentifierInterface');

        $this->subject->setId(true);
    }

    /**
     * @test
     */
    public function hasPropertyReturnsTrueIfPropertyExists(): void
    {
        self::assertTrue(
            $this->subject->hasProperty('name')
        );
    }

    /**
     * @test
     */
    public function hasPropertyReturnsFalseIfPropertyDoesNotExists(): void
    {
        self::assertFalse(
            $this->subject->hasProperty('propertyDoesNotExist')
        );
    }

    /**
     * @test
     */
    public function setPropertyReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->subject->setProperty('name', 'the name');

        self::assertInstanceOf(AbstractType::class, $actual);
    }

    /**
     * @test
     */
    public function setPropertyAcceptsValidDataTypesAsValue(): void
    {
        // Test is valid, when no exception is thrown
        self::expectNotToPerformAssertions();

        $this->subject->setProperty('name', 'Pi');
        $this->subject->setProperty('description', ['The answer for everything']);
        $this->subject->setProperty('identifier', 42);
        $this->subject->setProperty('alternateName', 3.141592653);
        $this->subject->setProperty('image', new class() extends AbstractType {
        });
        $this->subject->setProperty('subjectOf', new class() implements NodeIdentifierInterface {
            public function getId(): ?string
            {
                return 'some-node-identifier';
            }
        });
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

        self::assertNull($actual);
    }

    /**
     * @test
     */
    public function getPropertyReturnsCorrectValue(): void
    {
        $actual = $this->subject
            ->setProperty('image', ['some image value', 'another image value'])
            ->getProperty('image');

        self::assertSame(['some image value', 'another image value'], $actual);
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

        self::assertSame('the test name', $actual);
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

        self::assertSame(['first image element', 'second image element'], $actual);
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

        self::assertSame(['some image value', 'other image value'], $actual);
    }

    /**
     * @test
     */
    public function addPropertyAcceptsStringsAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->setProperty('name', 'some name');
        $this->subject->setProperty('name', 'another name');
        $this->subject->setProperty('name', 'one more name');
    }

    /**
     * @test
     */
    public function addPropertyAcceptsArraysAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->setProperty('description', ['some description']);
        $this->subject->setProperty('description', ['another description']);
        $this->subject->setProperty('description', ['one more description']);
    }

    /**
     * @test
     */
    public function addPropertyAcceptsIntegerAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->addProperty('identifier', 1);
        $this->subject->addProperty('identifier', 2);
        $this->subject->addProperty('identifier', 3);
    }

    /**
     * @test
     */
    public function addPropertyAcceptsBooleanAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->addProperty('isAccessibleForFree', true);
        $this->subject->addProperty('isAccessibleForFree', false);
        $this->subject->addProperty('isAccessibleForFree', true);
    }

    /**
     * @test
     */
    public function addPropertyAcceptsFloatAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->addProperty('alternateName', 3.141592653);
        $this->subject->addProperty('alternateName', 3.2);
        $this->subject->addProperty('alternateName', 3.3);
    }

    /**
     * @test
     */
    public function addPropertyAcceptsTypeAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->addProperty('image', new class() extends AbstractType {
        });
        $this->subject->addProperty('image', new class() extends AbstractType {
        });
        $this->subject->addProperty('image', new class() extends AbstractType {
        });
    }

    /**
     * @test
     */
    public function addPropertyAcceptsNodeIdentifierAsValue(): void
    {
        // Valid, when no exception is thrown
        $this->expectNotToPerformAssertions();

        $this->subject->addProperty('subjectOf', new class() implements NodeIdentifierInterface {
            public function getId(): ?string
            {
                return 'some-node-identifier';
            }
        });
        $this->subject->addProperty('subjectOf', new class() implements NodeIdentifierInterface {
            public function getId(): ?string
            {
                return 'another-node-identifier';
            }
        });
        $this->subject->addProperty('subjectOf', new class() implements NodeIdentifierInterface {
            public function getId(): ?string
            {
                return 'one-more-node-identifier';
            }
        });
    }

    /**
     * @test
     */
    public function setPropertiesReturnsReferenceToItself(): void
    {
        $actual = $this->subject->setProperties([]);

        self::assertInstanceOf(AbstractType::class, $actual);
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

        self::assertSame('some name', $actualName);

        $actualDescription = $this->subject->getProperty('description');

        self::assertSame('some description', $actualDescription);

        $actualImage = $this->subject->getProperty('image');

        self::assertSame(['some image value', 'other image value'], $actualImage);
    }

    /**
     * @test
     */
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
            $actual
        );
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::__construct()
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::addAdditionalProperties()
     */
    public function cacheForAdditionalPropertiesReturnsPropertiesAndTheseAreAddedSortedIntoPropertiesArray(): void
    {
        $cacheFrontendStub = $this->createStub(FrontendInterface::class);
        $cacheFrontendStub
            ->method('get')
            ->willReturn(['someAdditionalProperty', 'anotherAdditionalProperty']);

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with(Extension::CACHE_IDENTIFIER)
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        $subject = new Thing();

        self::assertSame(
            [
                'alternateName',
                'anotherAdditionalProperty',
                'description',
                'identifier',
                'image',
                'isAccessibleForFree',
                'name',
                'someAdditionalProperty',
                'subjectOf',
                'url',
            ],
            $subject->getPropertyNames()
        );
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::__construct()
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::addAdditionalProperties()
     */
    public function cacheForAdditionalPropertiesReturnsFalseAndDispatcherIsCalled(): void
    {
        $cacheFrontendMock = $this->createStub(FrontendInterface::class);
        $cacheFrontendMock
            ->expects(self::once())
            ->method('get')
            ->with('additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_Thing')
            ->willReturn(false);

        $cacheFrontendMock
            ->method('set')
            ->with(
                'additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_Thing',
                [],
                [],
                0
            );

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with(Extension::CACHE_IDENTIFIER)
            ->willReturn($cacheFrontendMock);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        if (\class_exists(EventDispatcher::class)) {
            /* Only TYPO3 v10+ */
            $event = new RegisterAdditionalTypePropertiesEvent(Thing::class);

            /** @var MockObject|EventDispatcher $eventDispatcherMock */
            $eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
                ->disableOriginalConstructor()
                ->getMock();
            $eventDispatcherMock
                ->expects(self::once())
                ->method('dispatch')
                ->with($event)
                ->willReturn($event);

            GeneralUtility::setSingletonInstance(EventDispatcher::class, $eventDispatcherMock);
        }

        new Thing();
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::__construct()
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::addAdditionalProperties()
     */
    public function cacheForAdditionalPropertiesReturnsFalseAndEventDispatcherIsCalled(): void
    {
        if (!\class_exists(EventDispatcher::class)) {
            self::markTestSkipped('Only TYPO3 v10+');
        }

        $cacheFrontendMock = $this->createStub(FrontendInterface::class);
        $cacheFrontendMock
            ->expects(self::once())
            ->method('get')
            ->with('additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_Thing')
            ->willReturn(false);

        $cacheFrontendMock
            ->method('set')
            ->with(
                'additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_Thing',
                ['someAdditionalProperty'],
                [],
                0
            );

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with(Extension::CACHE_IDENTIFIER)
            ->willReturn($cacheFrontendMock);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        $inEvent = new RegisterAdditionalTypePropertiesEvent(Thing::class);

        $outEvent = new RegisterAdditionalTypePropertiesEvent(Thing::class);
        $outEvent->registerAdditionalProperty('someAdditionalProperty');

        /** @var MockObject|EventDispatcher $eventDispatcherMock */
        $eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eventDispatcherMock
            ->expects(self::once())
            ->method('dispatch')
            ->with($inEvent)
            ->willReturn($outEvent);

        GeneralUtility::setSingletonInstance(EventDispatcher::class, $eventDispatcherMock);

        new Thing();
    }

    /**
     * @test
     * @covers \Brotkrueml\Schema\Core\Model\AbstractType::getType()
     */
    public function getTypeReturnsTypeCorrectlyWhenClassNameStartsWithUnderscore(): void
    {
        $type = new _3DModel();

        self::assertSame('3DModel', $type->getType());
    }
}
