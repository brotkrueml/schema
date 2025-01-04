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
 * Classification of the album by its type of content: soundtrack, live album, studio album, etc.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum MusicAlbumProductionType implements EnumerationInterface
{
    /**
     * CompilationAlbum.
     */
    case CompilationAlbum;

    /**
     * DJMixAlbum.
     */
    case DJMixAlbum;

    /**
     * DemoAlbum.
     */
    case DemoAlbum;

    /**
     * LiveAlbum.
     */
    case LiveAlbum;

    /**
     * MixtapeAlbum.
     */
    case MixtapeAlbum;

    /**
     * RemixAlbum.
     */
    case RemixAlbum;

    /**
     * SoundtrackAlbum.
     */
    case SoundtrackAlbum;

    /**
     * SpokenWordAlbum.
     */
    case SpokenWordAlbum;

    /**
     * StudioAlbum.
     */
    case StudioAlbum;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
