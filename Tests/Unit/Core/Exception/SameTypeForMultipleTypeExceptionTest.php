<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Exception;

use Brotkrueml\Schema\Core\Exception\SameTypeForMultipleTypeException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(SameTypeForMultipleTypeException::class)]
final class SameTypeForMultipleTypeExceptionTest extends TestCase
{
    #[Test]
    public function fromSingleTypes(): void
    {
        $actual = SameTypeForMultipleTypeException::fromSingleTypes(['SomeType', 'AnotherType', 'SomeType']);

        self::assertSame(
            'Only different types can be used as arguments for a multiple type, "SomeType, AnotherType, SomeType" given',
            $actual->getMessage(),
        );
        self::assertSame(1621871950, $actual->getCode());
    }
}
