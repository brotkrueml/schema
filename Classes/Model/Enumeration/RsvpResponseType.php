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
 * RsvpResponseType is an enumeration type whose instances represent responding to an RSVP request.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum RsvpResponseType implements EnumerationInterface
{
    /**
     * The invitee may or may not attend.
     */
    case RsvpResponseMaybe;

    /**
     * The invitee will not attend.
     */
    case RsvpResponseNo;

    /**
     * The invitee will attend.
     */
    case RsvpResponseYes;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
