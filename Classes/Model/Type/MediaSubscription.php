<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A subscription which allows a user to access media including audio, video, books, etc.
 */
final class MediaSubscription extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'authenticator' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'expectsAcceptanceOf' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
