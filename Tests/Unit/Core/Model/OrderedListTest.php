<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Model;

use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\OrderedList;
use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderedList::class)]
final class OrderedListTest extends TestCase
{
    #[Test]
    #[DataProvider('provider')]
    public function getItems(array $items): void
    {
        $subject = new OrderedList(...$items);

        $actual = $subject->getItems();

        self::assertSame($items, $actual);
    }

    public static function provider(): iterable
    {
        yield 'with no items' => [
            'items' => [],
        ];

        yield 'with multiple string items' => [
            'items' => [
                'foo',
                'bar',
            ],
        ];

        yield 'with multiple node identifiers items' => [
            'items' => [
                new class implements NodeIdentifierInterface {
                    public function getId(): string
                    {
                        return 'https://example.com/#some-node';
                    }
                },
                new class implements NodeIdentifierInterface {
                    public function getId(): string
                    {
                        return 'https://example.com/#another-node';
                    }
                },
            ],
        ];

        yield 'with multiple type items' => [
            'items' => [
                new ProductStub(),
                new ServiceStub(),
            ],
        ];

        yield 'with multiple mixed items' => [
            'items' => [
                'foo',
                new class implements NodeIdentifierInterface {
                    public function getId(): string
                    {
                        return 'https://example.com/#some-node';
                    }
                },
                new GenericStub(),
            ],
        ];
    }

    #[Test]
    public function getItemsWithNonStringsThrowTypeError(): void
    {
        $this->expectException(\TypeError::class);

        new OrderedList(new \stdClass());
    }
}
