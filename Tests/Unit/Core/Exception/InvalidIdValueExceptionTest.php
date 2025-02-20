<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Exception;

use Brotkrueml\Schema\Core\Exception\InvalidIdValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidIdValueException::class)]
final class InvalidIdValueExceptionTest extends TestCase
{
    #[Test]
    public function fromDebugType(): void
    {
        $actual = InvalidIdValueException::fromValueType('invalid_type');

        self::assertSame(
            'Value for id has not a valid data type (given: "invalid_type"). Valid types are: null, string, instanceof NodeIdentifierInterface',
            $actual->getMessage(),
        );
        self::assertSame(1620654936, $actual->getCode());
    }
}
