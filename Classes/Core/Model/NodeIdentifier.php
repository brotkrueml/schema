<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

class NodeIdentifier implements NodeIdentifierInterface, \Stringable
{
    public function __construct(
        /**
         * The ID of the type (mapped to @id in result)
         */
        private readonly string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
