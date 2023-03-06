<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Type;

use Brotkrueml\Schema\Core\Model\MultipleType;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use Brotkrueml\Schema\Type\ModelClassNotFoundException;
use Brotkrueml\Schema\Type\TypeFactory;
use Brotkrueml\Schema\Type\TypeProvider;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @covers \Brotkrueml\Schema\Type\TypeFactory
 */
final class TypeFactoryTest extends TestCase
{
    private TypeProvider $typeProvider;

    protected function setUp(): void
    {
        $this->typeProvider = new TypeProvider();
        GeneralUtility::setSingletonInstance(TypeProvider::class, $this->typeProvider);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function createTypeWithNoArgumentThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1621787452);
        $this->expectExceptionMessage('At least one type has to be given as argument');

        TypeFactory::createType();
    }

    /**
     * @test
     */
    public function createTypeWithSingleArgumentReturnsInstanceOfTypeModel(): void
    {
        $this->typeProvider->addType('GenericStub', GenericStub::class);

        $type = TypeFactory::createType('GenericStub');

        self::assertInstanceOf(GenericStub::class, $type);
    }

    /**
     * @test
     */
    public function createTypeWithSingleArgumentThrowsExceptionOnInvalidType(): void
    {
        $this->expectException(ModelClassNotFoundException::class);

        TypeFactory::createType('UnavailableType');
    }

    /**
     * @test
     */
    public function createTypeWithTwoArgumentsReturnsInstanceOfMultipleType(): void
    {
        $this->typeProvider->addType('ProductStub', ProductStub::class);
        $this->typeProvider->addType('ServiceStub', ServiceStub::class);

        $actual = TypeFactory::createType('ProductStub', 'ServiceStub');

        self::assertInstanceOf(MultipleType::class, $actual);
        self::assertSame(['ProductStub', 'ServiceStub'], $actual->getType());
    }

    /**
     * @test
     */
    public function createTypeWithTwoSameArgumentsReturnsSingleTypeInstance(): void
    {
        $this->typeProvider->addType('GenericStub', GenericStub::class);

        $type = TypeFactory::createType('GenericStub', 'GenericStub');

        self::assertInstanceOf(GenericStub::class, $type);
    }

    /**
     * @test
     */
    public function instantiatingTypeFactoryThrowsError(): void
    {
        $this->expectException(\Error::class);

        new TypeFactory();
    }
}
