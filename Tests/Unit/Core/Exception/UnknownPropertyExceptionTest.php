<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Exception;

use Brotkrueml\Schema\Core\Exception\UnknownPropertyException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(UnknownPropertyException::class)]
final class UnknownPropertyExceptionTest extends TestCase
{
    #[Test]
    public function fromPropertyNameWithTypeAsString(): void
    {
        $actual = UnknownPropertyException::fromPropertyName('SomeType', 'someProperty');

        self::assertSame('Property "someProperty" is unknown for type "SomeType"', $actual->getMessage());
        self::assertSame(1561829996, $actual->getCode());
    }

    #[Test]
    public function fromPropertyNameWithTypeAsArray(): void
    {
        $actual = UnknownPropertyException::fromPropertyName(['SomeType', 'AnotherType'], 'someProperty');

        self::assertSame('Property "someProperty" is unknown for type "SomeType / AnotherType"', $actual->getMessage());
        self::assertSame(1561829996, $actual->getCode());
    }
}
