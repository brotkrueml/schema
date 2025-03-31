<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

#[Type('Thing')]
class ThingWithResolvedTypesExposed extends AbstractType
{
    /**
     * @var string[]
     */
    protected static array $propertyNames = [
        'alternateName',
        'description',
        'identifier',
        'image',
        'isAccessibleForFree',
        'name',
        'subjectOf',
        'url',
    ];

    /**
     * We have to overwrite the construct method, because it triggers the deprecation with "new".
     * The type is resolved there, which is not desired.
     * @todo Remove again for 4.0.0
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct()
    {
        // There seems to be a leak since adding the deprecation for manual instantiation,
        // as other types are already added here. For the test we can initialise the
        // property again. Not nice, but works for now.
        static::$resolvedTypes = [];
    }

    public function getResolvedTypes(): array
    {
        return static::$resolvedTypes;
    }
}
