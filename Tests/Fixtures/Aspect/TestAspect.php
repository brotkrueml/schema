<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Fixtures\Aspect;

use Brotkrueml\Schema\Aspect\AspectInterface;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureThing;

class TestAspect implements AspectInterface
{
    public function execute(SchemaManager $schemaManager): void
    {
        $schemaManager->addType(new FixtureThing());
    }
}
