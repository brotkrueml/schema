<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Exception;

use Brotkrueml\Schema\Core\Exception\InvalidPropertyValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidPropertyValueException::class)]
final class InvalidPropertyValueExceptionTest extends TestCase
{
    #[Test]
    public function fromValueType(): void
    {
        $actual = InvalidPropertyValueException::fromValueType('someProperty', 'invalid_type');

        self::assertSame(
            'Value for property "someProperty" has not a valid data type (given: "invalid_type"). Valid types are: null, string, int, array, bool, instanceof TypeInterface, instanceof NodeIdentifierInterface',
            $actual->getMessage(),
        );
        self::assertSame(1561830012, $actual->getCode());
    }
}
