<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Core\Exception;

use Brotkrueml\Schema\Core\Exception\MissingBreadcrumbArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MissingBreadcrumbArgumentException::class)]
final class MissingBreadcrumbArgumentExceptionTest extends TestCase
{
    #[Test]
    public function fromMissingTitle(): void
    {
        $breadcrumb = [
            [
                'title' => 'Some page',
                'link' => '/',
            ],
            [
                'link' => '/sub-page/',
            ],
        ];

        $actual = MissingBreadcrumbArgumentException::fromMissingTitle($breadcrumb);

        self::assertSame(
            'An item in the given breadcrumb structure does not have the "title" key, given: [{"title":"Some page","link":"\/"},{"link":"\/sub-page\/"}]',
            $actual->getMessage(),
        );
        self::assertSame(1561890280, $actual->getCode());
    }

    #[Test]
    public function fromMissingLink(): void
    {
        $breadcrumb = [
            [
                'title' => 'Some page',
                'link' => '/',
            ],
            [
                'title' => 'Some sub page',
            ],
        ];

        $actual = MissingBreadcrumbArgumentException::fromMissingLink($breadcrumb);

        self::assertSame(
            'An item in the given breadcrumb structure does not have the "link" key, given: [{"title":"Some page","link":"\/"},{"title":"Some sub page"}]',
            $actual->getMessage(),
        );
        self::assertSame(1561890281, $actual->getCode());
    }
}
