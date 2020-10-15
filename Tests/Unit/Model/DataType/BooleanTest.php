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
