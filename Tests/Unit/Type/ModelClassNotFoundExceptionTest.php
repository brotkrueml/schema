<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Type;

use Brotkrueml\Schema\Type\ModelClassNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Brotkrueml\Schema\Type\ModelClassNotFoundException
 */
final class ModelClassNotFoundExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function fromType(): void
    {
        $actual = ModelClassNotFoundException::fromType('SomeType');

        self::assertInstanceOf(\DomainException::class, $actual);
        self::assertSame('No model class for type "SomeType" available!', $actual->getMessage());
        self::assertSame(1586590157, $actual->getCode());
    }
}
