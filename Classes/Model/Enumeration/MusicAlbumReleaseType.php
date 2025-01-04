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
 * The kind of release which this album is: single, EP or album.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum MusicAlbumReleaseType implements EnumerationInterface
{
    /**
     * AlbumRelease.
     */
    case AlbumRelease;

    /**
     * BroadcastRelease.
     */
    case BroadcastRelease;

    /**
     * EPRelease.
     */
    case EPRelease;

    /**
     * SingleRelease.
     */
    case SingleRelease;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
