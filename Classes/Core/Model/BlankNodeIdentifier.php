<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

class BlankNodeIdentifier implements NodeIdentifierInterface, \Stringable
{
    /**
     * The ID of the type (mapped to @id in result)
     */
    private readonly string $id;

    /**
     * @param bool $resetCounter This argument is internal and for testing purposes only and may be removed at any time!
     */
    public function __construct(bool $resetCounter = false)
    {
        static $counter = 0;
        if ($resetCounter) {
            $counter = 0;
        }
        $this->id = '_:b' . $counter++;
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
