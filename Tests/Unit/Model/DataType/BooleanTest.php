<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Model\DataType;

use Brotkrueml\Schema\Model\DataType\Boolean;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    /**
     * @test
     */
    public function convertToValueWithTrue(): void
    {
        self::assertSame(Boolean::TRUE, Boolean::convertToType(true));
    }

    /**
     * @test
     */
    public function convertToValueWithFalse(): void
    {
        self::assertSame(Boolean::FALSE, Boolean::convertToType(false));
    }
}
