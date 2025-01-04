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
 * A type of permission which can be granted for accessing a digital document.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum DigitalDocumentPermissionType implements EnumerationInterface
{
    /**
     * Permission to add comments to the document.
     */
    case CommentPermission;

    /**
     * Permission to read or view the document.
     */
    case ReadPermission;

    /**
     * Permission to write or edit the document.
     */
    case WritePermission;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
