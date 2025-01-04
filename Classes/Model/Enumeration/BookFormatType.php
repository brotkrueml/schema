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
     * Book format: GraphicNovel. May represent a bound collection of ComicIssue instances.
     */
    case GraphicNovel;

    /**
     * Book format: Hardcover.
     */
    case Hardcover;

    /**
     * Book format: Paperback.
     */
    case Paperback;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
