<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * The publication format of the book.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum BookFormatType implements EnumerationInterface
{
    /**
     * Book format: Audiobook. This is an enumerated value for use with the bookFormat property. There is also a type 'Audiobook' in the bib extension which includes Audiobook specific properties.
     */
    case AudiobookFormat;

    /**
     * Book format: Ebook.
     */
    case EBook;

    /**
     * This type is deprecated: GraphicNovel does not fit the BookFormatType enumeration, as it can appear in multiple formats (e.g., Hardcover, eBook). It is not mutually exclusive and therefore deprecated. Use standard BookFormatType values instead in combination with the SequentialArt.
     *
     * Book format: GraphicNovel. May represent a bound collection of ComicIssue instances.
     */
    case GraphicNovel;

    /**
     * A durable, archival-quality book featuring a rigid protective shell made of heavy board wrapped in cloth or paper, designed to withstand heavy use and preservation on a shelf.
     */
    case Hardcover;

    /**
     * A small, unbound or stapled booklet consisting of few pages with a flexible paper cover, designed for the economical distribution of focused information on a single subject.
     */
    case Pamphlet;

    /**
     * A flexible, lightweight book bound with a thick paper or cardstock cover and glued spine, prioritizing portability and affordability over long-term durability.
     */
    case Paperback;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
