<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\Model\BlankNodeIdentifier;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(BlankNodeIdentifier::class)]
final class BlankNodeIdentifierTest extends TestCase
{
    #[Test]
    public function subjectIsInstanceOfNodeIdentifierInterface(): void
    {
        self::assertInstanceOf(NodeIdentifierInterface::class, new BlankNodeIdentifier());
    }

    #[Test]
    public function subjectIsInstanceOfStringableInterface(): void
    {
        self::assertInstanceOf(\Stringable::class, new BlankNodeIdentifier());
    }

    #[Test]
    public function getIdReturnsBlankIdentifier(): void
    {
        $subject = new BlankNodeIdentifier(true);

        self::assertSame('_:b0', $subject->getId());
    }

    #[Test]
    public function getIdOnConsecutiveInstantiationsReturnsAscendingBlankIdentifiers(): void
    {
        $actual = [
            (new BlankNodeIdentifier(true))->getId(),
            (new BlankNodeIdentifier())->getId(),
            (new BlankNodeIdentifier())->getId(),
            (new BlankNodeIdentifier())->getId(),
        ];

        $expected = [
            '_:b0',
            '_:b1',
            '_:b2',
            '_:b3',
        ];

        self::assertSame($expected, $actual);
    }

    #[Test]
    public function toStringReturnsBlankIdentifier(): void
    {
        $subject = new BlankNodeIdentifier(true);

        self::assertSame('_:b0', $subject->__toString());
    }
}
