<?php

namespace Brotkrueml\Schema\Tests\Unit\Generator\Model;

use Brotkrueml\Schema\Generator\Model\Type;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
    /**
     * @test
     */
    public function classPropertiesAreAvailable(): void
    {
        $type = new Type();
        $type->id = 'fake id';
        $type->label = 'fake label';
        $type->comment = 'fake comment';
        $type->subClassOf = ['fake subclass'];
        $type->properties = ['fake properties'];

        $this->assertSame('fake id', $type->id);
        $this->assertSame('fake label', $type->label);
        $this->assertSame('fake comment', $type->comment);
        $this->assertSame(['fake subclass'], $type->subClassOf);
        $this->assertSame(['fake properties'], $type->properties);
    }
}
