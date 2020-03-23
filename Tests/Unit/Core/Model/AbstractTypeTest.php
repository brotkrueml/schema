<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Model\DataType\Boolean;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureImage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

class AbstractTypeTest extends TestCase
{
    use SchemaCacheTrait;

    /**
     * @var AbstractType
     */
    protected $subject;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();
        $this->subject = new FixtureThing();
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function setIdReturnsInstanceOfAbstractClass(): void
    {
        $actual = $this->subject->setId('concreteTestId');

        self::assertInstanceOf(AbstractType::class, $actual);
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
    public function getIdReturnsTheIdCorrectly(): void
    {
        $this->subject->setId('concreteTestId');

        $actual = $this->subject->getId();

        self::assertSame('concreteTestId', $actual);
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
        $this->subject->setProperty('name', 'Pi');
        $this->subject->setProperty('description', ['The answert for everything']);
        $this->subject->setProperty('identifier', 42);
        $this->subject->setProperty('alternateName', 3.141592653);

        $anotherType = new class extends AbstractType {
        };

        $this->subject->setProperty('image', $anotherType);

        // Assertion is valid, when no exception above is thrown
        self::assertTrue(true);
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
    public function addPropertyAcceptsValidDataTypesAsValue(): void
    {
        $this->subject->setProperty('name', 'Pi');
        $this->subject->setProperty('description', ['The answert for everything']);
        $this->subject->addProperty('identifier', 42);
        $this->subject->addProperty('isAccessibleForFree', true);
        $this->subject->addProperty('alternateName', 3.141592653);

        $anotherType = new class extends AbstractType {
        };

        $this->subject->addProperty('image', $anotherType);

        // Assertion is valid, when no exception above is thrown
        self::assertTrue(true);
    }

    /**
     * @test
     */
    public function toArrayIsCorrectWhenAddPropertyCalledMultipleTimesOnTheSamePropertyName(): void
    {
        $this->subject->addProperty('name', 'name 1');
        $this->subject->addProperty('name', 'name 2');
        $this->subject->addProperty('name', 'name 3');

        $this->subject->addProperty('alternateName', ['alternateName 1']);
        $this->subject->addProperty('alternateName', ['alternateName 2']);
        $this->subject->addProperty('alternateName', ['alternateName 3']);

        $this->subject->addProperty('isAccessibleForFree', true);
        $this->subject->addProperty('isAccessibleForFree', false);
        $this->subject->addProperty('isAccessibleForFree', true);

        $this->subject->addProperty('image', (new FixtureImage())->setProperty('name', 'someValue 1'));
        $this->subject->addProperty('image', (new FixtureImage())->setProperty('name', 'someValue 2'));
        $this->subject->addProperty('image', (new FixtureImage())->setProperty('name', 'someValue 3'));

        $actual = $this->subject->toArray();

        self::assertSame('FixtureThing', $actual['@type']);
        self::assertSame(['alternateName 1', 'alternateName 2', 'alternateName 3'], $actual['alternateName']);
        self::assertSame(
            ['http://schema.org/True', 'http://schema.org/False', 'http://schema.org/True'],
            $actual['isAccessibleForFree']
        );
        self::assertSame(['name 1', 'name 2', 'name 3'], $actual['name']);
        self::assertSame('someValue 1', $actual['image'][0]['name']);
        self::assertSame('someValue 2', $actual['image'][1]['name']);
        self::assertSame('someValue 3', $actual['image'][2]['name']);
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

        self::assertTrue($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsFalseIfOnePropertyHasStringValue(): void
    {
        $this->subject->setProperty('name', 'some name');

        $actual = $this->subject->isEmpty();

        self::assertFalse($actual);
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

        self::assertTrue($actual);
    }

    /**
     * @test
     */
    public function isEmptyReturnsFalseWithOnePropertySetToFalse(): void
    {
        $this->subject->setProperty('isAccessibleForFree', false);

        $actual = $this->subject->isEmpty();

        self::assertFalse($actual);
    }

    public function dataProviderForToArrayReturnsCorrectResult(): iterable
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

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

        yield 'Value is the number 0.10 as float' => [
            'name',
            0.10,
            [
                '@type' => 'FixtureThing',
                'name' => '0.1',
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

        yield 'value is a boolean (true)' => [
            'isAccessibleForFree',
            true,
            [
                '@type' => 'FixtureThing',
                'isAccessibleForFree' => Boolean::TRUE,
            ],
        ];

        yield 'value is a boolean (false)' => [
            'isAccessibleForFree',
            false,
            [
                '@type' => 'FixtureThing',
                'isAccessibleForFree' => Boolean::FALSE,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForToArrayReturnsCorrectResult
     * @param string $key
     * @param string|array|bool|AbstractType $value
     * @param array $expected
     */
    public function toArrayReturnsCorrectResult(string $key, $value, array $expected): void
    {
        $actual = $this->subject
            ->setProperty($key, $value)
            ->toArray();

        self::assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function toArrayReturnsCorrectResultWhenNoPropertiesAreSet(): void
    {
        $actual = $this->subject->toArray();

        self::assertSame(['@type' => 'FixtureThing'], $actual);
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
            ->with('tx_schema')
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        $subject = new FixtureThing();

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
            ->with('additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_FixtureThing')
            ->willReturn(false);

        $cacheFrontendMock
            ->method('set')
            ->with(
                'additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_FixtureThing',
                [],
                [],
                0
            );

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with('tx_schema')
            ->willReturn($cacheFrontendMock);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        /** @var MockObject|Dispatcher $signalSlotDispatcherMock */
        $signalSlotDispatcherMock = $this->getMockBuilder(Dispatcher::class)
            ->disableOriginalConstructor()
            ->getMock();
        $signalSlotDispatcherMock
            ->expects(self::once())
            ->method('dispatch')
            ->with(AbstractType::class, 'registerAdditionalTypeProperties');

        GeneralUtility::setSingletonInstance(Dispatcher::class, $signalSlotDispatcherMock);

        if (\class_exists(EventDispatcher::class)) {
            /* Only TYPO3 v10+ */
            $event = new RegisterAdditionalTypePropertiesEvent(FixtureThing::class);

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

        new FixtureThing();
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
            ->with('additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_FixtureThing')
            ->willReturn(false);

        $cacheFrontendMock
            ->method('set')
            ->with(
                'additionalTypeProperties-Brotkrueml_Schema_Tests_Fixtures_Model_Type_FixtureThing',
                ['someAdditionalProperty'],
                [],
                0
            );

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with('tx_schema')
            ->willReturn($cacheFrontendMock);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);

        /** @var MockObject|Dispatcher $signalSlotDispatcherMock */
        $signalSlotDispatcherMock = $this->getMockBuilder(Dispatcher::class)
            ->disableOriginalConstructor()
            ->getMock();
        $signalSlotDispatcherMock
            ->expects(self::once())
            ->method('dispatch')
            ->with(AbstractType::class, 'registerAdditionalTypeProperties');

        GeneralUtility::setSingletonInstance(Dispatcher::class, $signalSlotDispatcherMock);

        $inEvent = new RegisterAdditionalTypePropertiesEvent(FixtureThing::class);

        $outEvent = new RegisterAdditionalTypePropertiesEvent(FixtureThing::class);
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

        new FixtureThing();
    }
}
