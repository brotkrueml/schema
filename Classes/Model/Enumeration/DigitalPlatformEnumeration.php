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
 * Enumerates some common technology platforms, for use with properties such as actionPlatform. It is not supposed to be comprehensive - when a suitable code is not enumerated here, textual or URL values can be used instead. These codes are at a fairly high level and do not deal with versioning and other nuance. Additional codes can be suggested [in github](https://github.com/schemaorg/schemaorg/issues/3057).
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum DigitalPlatformEnumeration implements EnumerationInterface
{
    /**
     * Represents the broad notion of Android-based operating systems.
     */
    case AndroidPlatform;

    /**
     * Represents the broad notion of 'desktop' browsers as a Web Platform.
     */
    case DesktopWebPlatform;

    /**
     * Represents the generic notion of the Web Platform. More specific codes include MobileWebPlatform and DesktopWebPlatform, as an incomplete list.
     */
    case GenericWebPlatform;

    /**
     * Represents the broad notion of iOS-based operating systems.
     */
    case IOSPlatform;

    /**
     * Represents the broad notion of 'mobile' browsers as a Web Platform.
     */
    case MobileWebPlatform;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
