<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core;

/**
 * @api
 */
interface AdditionalPropertiesInterface
{
    /**
     * @return non-empty-string
     */
    public function getType(): string;

    /**
     * @return list<non-empty-string>
     */
    public function getAdditionalProperties(): array;
}
