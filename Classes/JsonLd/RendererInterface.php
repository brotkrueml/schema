<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\JsonLd;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\TypeInterface;

/**
 * @internal
 */
interface RendererInterface
{
    public function addType(TypeInterface ...$type): void;

    public function clearTypes(): void;

    public function render(): string;
}
