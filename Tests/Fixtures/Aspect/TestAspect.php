<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Aspect;

use Brotkrueml\Schema\Aspect\AspectInterface;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;

class TestAspect implements AspectInterface
{
    public function execute(SchemaManager $schemaManager): void
    {
        $schemaManager->addType(new Thing());
    }
}
