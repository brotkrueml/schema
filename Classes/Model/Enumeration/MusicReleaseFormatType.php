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
 * Format of this release (the type of recording media used, i.e. compact disc, digital media, LP, etc.).
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum MusicReleaseFormatType implements EnumerationInterface
{
    /**
     * CDFormat.
     */
    case CDFormat;

    /**
     * CassetteFormat.
     */
    case CassetteFormat;

    /**
     * DVDFormat.
     */
    case DVDFormat;

    /**
     * DigitalAudioTapeFormat.
     */
    case DigitalAudioTapeFormat;

    /**
     * DigitalFormat.
     */
    case DigitalFormat;

    /**
     * LaserDiscFormat.
     */
    case LaserDiscFormat;

    /**
     * VinylFormat.
     */
    case VinylFormat;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
