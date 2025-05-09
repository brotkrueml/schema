<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Model\AdditionalProperties;

use Brotkrueml\Schema\Core\AdditionalPropertiesInterface;

final class Event implements AdditionalPropertiesInterface
{
    public function getType(): string
    {
        return 'Event';
    }

    public function getAdditionalProperties(): array
    {
        return [
            'additional-event-property',
        ];
    }
}
