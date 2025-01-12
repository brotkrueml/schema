<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Model\DataType;

use Brotkrueml\Schema\Model\DataType\Boolean;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Boolean::class)]
final class BooleanTest extends TestCase
{
    #[Test]
    public function convertToTermWithArgumentTrue(): void
    {
        self::assertSame(Boolean::TRUE, Boolean::convertToTerm(true));
    }

    #[Test]
    public function convertToTermWithArgumentFalse(): void
    {
        self::assertSame(Boolean::FALSE, Boolean::convertToTerm(false));
    }
}
