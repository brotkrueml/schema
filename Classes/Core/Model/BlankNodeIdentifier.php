<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

/**
 * This class represents a blank node identifier. Blank node identifiers begin with "_:".
 * @see https://json-ld.github.io/json-ld.org/spec/latest/json-ld/#identifying-blank-nodes
 */
final readonly class BlankNodeIdentifier implements NodeIdentifierInterface, \Stringable
{
    private const PREFIX = '_:b';

    /**
     * The ID of the type (mapped to @id in result)
     */
    private string $id;

    public function __construct()
    {
        static $counter = 0;
        $this->id = self::PREFIX . $counter++;
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
