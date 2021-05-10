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
 * @psalm-immutable
 */
class NodeIdentifier implements NodeIdentifierInterface
{
    /**
     * The ID of the type (mapped to @id in result)
     */
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }
}
