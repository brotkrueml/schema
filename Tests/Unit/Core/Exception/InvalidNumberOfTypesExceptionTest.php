<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Exception;

use Brotkrueml\Schema\Core\Exception\InvalidNumberOfTypesException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidNumberOfTypesException::class)]
final class InvalidNumberOfTypesExceptionTest extends TestCase
{
    #[Test]
    public function fromSingleTypesWithNoneGiven(): void
    {
        $actual = InvalidNumberOfTypesException::fromSingleTypes([]);

        self::assertSame(
            'At least two types have to be assigned, "" (0) given',
            $actual->getMessage(),
        );
        self::assertSame(1621871446, $actual->getCode());
    }

    #[Test]
    public function fromSingleTypesWithOneGiven(): void
    {
        $actual = InvalidNumberOfTypesException::fromSingleTypes(['SomeType']);

        self::assertSame(
            'At least two types have to be assigned, "SomeType" (1) given',
            $actual->getMessage(),
        );
        self::assertSame(1621871446, $actual->getCode());
    }
}
