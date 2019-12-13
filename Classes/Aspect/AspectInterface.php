<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Aspect;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Manager\SchemaManager;

interface AspectInterface
{
    public function execute(SchemaManager $schemaManager): void;
}
