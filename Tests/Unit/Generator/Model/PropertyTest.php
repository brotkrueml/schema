<?php

namespace Brotkrueml\Schema\Tests\Unit\Generator\Model;

use Brotkrueml\Schema\Generator\Model\Property;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    /**
     * @test
     */
    public function classPropertiesAreAvailable(): void
    {
        $type = new Property();
        $type->id = 'fake id';
        $type->label = 'fake label';
        $type->comment = 'fake comment';

        $this->assertSame('fake id', $type->id);
        $this->assertSame('fake label', $type->label);
        $this->assertSame('fake comment', $type->comment);
    }

}
