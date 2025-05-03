<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\Exception\InvalidNumberOfTypesException;
use Brotkrueml\Schema\Core\Exception\SameTypeForMultipleTypeException;
use Brotkrueml\Schema\Core\Model\MultipleType;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MultipleType::class)]
final class MultipleTypeTest extends TestCase
{
    private MultipleType $subject;

    protected function setUp(): void
    {
        $this->subject = new MultipleType(
            (new ProductStub())->defineProperties([
                'name' => null,
                'serviceType' => null,
                'sku' => null,
            ]),
            new ServiceStub(),
        );
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
    public function instantiatingSubjectWithNoTypeGivenThrowsException(): void
    {
        $this->expectException(InvalidNumberOfTypesException::class);
        $this->expectExceptionCode(1621871446);

        new MultipleType();
    }

    #[Test]
    public function instantiatingSubjectWithOneTypeGivenThrowsException(): void
    {
        $this->expectException(InvalidNumberOfTypesException::class);
        $this->expectExceptionCode(1621871446);

        new MultipleType(new ProductStub());
    }

    #[Test]
    public function instantiatingSubjectWithTwoSameTypesGivenThrowsException(): void
    {
        $this->expectException(SameTypeForMultipleTypeException::class);
        $this->expectExceptionCode(1621871950);

        new MultipleType(new ProductStub(), new ProductStub(), new ServiceStub());
    }

    #[Test]
    public function getTypeReturnsTypesSortedAlphabetically(): void
    {
        $subject = new MultipleType(new ServiceStub(), new ProductStub());

        self::assertSame(['ProductStub', 'ServiceStub'], $subject->getType());
    }

    #[Test]
    public function propertiesFromTwoTypesAreMergedCorrectly(): void
    {
        self::assertSame(['name', 'serviceType', 'sku'], $this->subject->getPropertyNames());
    }

    #[Test]
    public function getTypeReturnsArrayOfTypesCorrectly(): void
    {
        self::assertSame(['ProductStub', 'ServiceStub'], $this->subject->getType());
    }

    #[Test]
    public function checkPropertyExistsDisplaysCorrectExceptionMessage(): void
    {
        $this->expectExceptionMessage('Property "notExisting" is unknown for type "ProductStub / ServiceStub"');

        $this->subject->setProperty('notExisting', 'some value');
    }
}
