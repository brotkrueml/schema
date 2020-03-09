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
    public function convertToTermWithArgumentTrue(): void
    {
        self::assertSame(Boolean::TRUE, Boolean::convertToTerm(true));
    }

    /**
     * @test
     */
    public function convertToTermWithArgumentFalse(): void
    {
        self::assertSame(Boolean::FALSE, Boolean::convertToTerm(false));
    }
}
