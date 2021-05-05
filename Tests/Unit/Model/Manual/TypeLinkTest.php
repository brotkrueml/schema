<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Model\Manual;

use Brotkrueml\Schema\Model\Manual\TypeLink;
use PHPUnit\Framework\TestCase;

class TypeLinkTest extends TestCase
{
    /**
     * @test
     */
    public function getterReturnCorrectValues(): void
    {
        $subject = new TypeLink(
            'https://example.org/SomeType',
            'Some title',
            'some-icon-identifier'
        );

        self::assertSame('https://example.org/SomeType', $subject->getLink());
        self::assertSame('Some title', $subject->getTitle());
        self::assertSame('some-icon-identifier', $subject->getIconIdentifier());
    }

    /**
     * @test
     * @dataProvider dataProviderWithInvalidUrls
     */
    public function exceptionThrownOnInvalidUrl(string $link): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1620237735);
        $this->expectExceptionMessage(\sprintf(
            'The given link "%s" ist not a valid URL!',
            $link
        ));

        new TypeLink($link, '', '');
    }

    public function dataProviderWithInvalidUrls(): \Iterator
    {
        yield ['no-link'];
        yield ['http://example.org'];
        yield ['https://example.org/Some Type'];
    }

    /**
     * @test
     */
    public function exceptionThrownOnInvalidWebUrl(): void
    {
        $link = 'ftp://some.host/';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1620237736);
        $this->expectExceptionMessage(\sprintf(
            'The given link "%s" ist not a valid web URL!',
            $link
        ));

        new TypeLink($link, '', '');
    }
}
