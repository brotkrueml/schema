<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\Model\MultipleType;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use PHPUnit\Framework\TestCase;

class MultipleTypeTest extends TestCase
{
    private MultipleType $subject;

    protected function setUp(): void
    {
        $this->subject = new MultipleType(new ProductStub(), new ServiceStub());
    }

    /**
     * @test
     */
    public function subjectImplementsTypeInterface(): void
    {
        self::assertInstanceOf(TypeInterface::class, $this->subject);
    }

    /**
     * @test
     */
    public function subjectImplementsNodeIdentifierInterface(): void
    {
        self::assertInstanceOf(NodeIdentifierInterface::class, $this->subject);
    }

    /**
     * @test
     */
    public function instantiatingSubjectWithNoTypeGivenThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1621871446);
        $this->expectExceptionMessage('At least two types have to be assigned, 0 given');

        new MultipleType();
    }

    /**
     * @test
     */
    public function instantiatingSubjectWithOneTypeGivenThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1621871446);
        $this->expectExceptionMessage('At least two types have to be assigned, 1 given');

        new MultipleType(new ProductStub());
    }

    /**
     * @test
     */
    public function instantiatingSubjectWithTwoSameTypesGivenThrowsException(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1621871950);
        $this->expectExceptionMessage('Only different types can be used as arguments for a multiple type, "ProductStub, ProductStub, ServiceStub" given');

        new MultipleType(new ProductStub(), new ProductStub(), new ServiceStub());
    }

    /**
     * @test
     */
    public function getTypeReturnsTypesSortedAlphabetically(): void
    {
        $subject = new MultipleType(new ServiceStub(), new ProductStub());

        self::assertSame(['ProductStub', 'ServiceStub'], $subject->getType());
    }

    /**
     * @test
     */
    public function propertiesFromTwoTypesAreMergedCorrectly(): void
    {
        self::assertSame(['name', 'serviceType', 'sku'], $this->subject->getPropertyNames());
    }

    /**
     * @test
     */
    public function getTypeReturnsArrayOfTypesCorrectly(): void
    {
        self::assertSame(['ProductStub', 'ServiceStub'], $this->subject->getType());
    }

    /**
     * @test
     */
    public function checkPropertyExistsDisplaysCorrectExceptionMessage(): void
    {
        $this->expectExceptionMessage('Property "notExisting" is unknown for type "ProductStub / ServiceStub"');

        $this->subject->setProperty('notExisting', 'some value');
    }
}
