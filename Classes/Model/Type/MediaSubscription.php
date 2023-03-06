<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A subscription which allows a user to access media including audio, video, books, etc.
 */
#[Type('MediaSubscription')]
final class MediaSubscription extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'authenticator',
        'description',
        'disambiguatingDescription',
        'expectsAcceptanceOf',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
