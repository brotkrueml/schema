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
 * Every schema.org enumeration type must implement this interface
 * @see https://schema.org/Enumeration
 * @experimental This interface is considered experimental and may change at any time until it is declared stable.
 */
interface EnumerationInterface
{
    public function canonical(): string;
}
