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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TypeFactory::class)]
final class TypeFactoryTest extends TestCase
{
    private TypeFactory $subject;
    private TypeProvider $typeProvider;

    protected function setUp(): void
    {
        $this->typeProvider = new TypeProvider();
        $this->subject = new TypeFactory($this->typeProvider);
    }

    #[Test]
    public function createWithNoArgumentThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1621787452);
        $this->expectExceptionMessage('At least one type has to be given as argument');

        $this->subject->create();
    }

    #[Test]
    public function createWithSingleArgumentReturnsInstanceOfTypeModel(): void
    {
        $this->typeProvider->addType('GenericStub', GenericStub::class);

        $type = $this->subject->create('GenericStub');

        self::assertInstanceOf(GenericStub::class, $type);
    }

    #[Test]
    public function createWithSingleArgumentThrowsExceptionOnInvalidType(): void
    {
        $this->expectException(ModelClassNotFoundException::class);

        $this->subject->create('UnavailableType');
    }

    #[Test]
    public function createWithTwoArgumentsReturnsInstanceOfMultipleType(): void
    {
        $this->typeProvider->addType('ProductStub', ProductStub::class);
        $this->typeProvider->addType('ServiceStub', ServiceStub::class);

        $actual = $this->subject->create('ProductStub', 'ServiceStub');

        self::assertInstanceOf(MultipleType::class, $actual);
        self::assertSame(['ProductStub', 'ServiceStub'], $actual->getType());
    }

    #[Test]
    public function createWithTwoSameArgumentsReturnsSingleTypeInstance(): void
    {
        $this->typeProvider->addType('GenericStub', GenericStub::class);

        $type = $this->subject->create('GenericStub', 'GenericStub');

        self::assertInstanceOf(GenericStub::class, $type);
    }
}
