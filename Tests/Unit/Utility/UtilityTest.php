<?php

namespace Brotkrueml\Schema\Tests\Unit\Utility;

use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Utility\Utility;
use PHPUnit\Framework\TestCase;

class UtilityTest extends TestCase
{
    /**
     * @test
     */
    public function getClassNameWithoutNamespaceReturnsCorrectResultWithGivenNamespacedClass(): void
    {
        $actual = Utility::getClassNameWithoutNamespace('\\This\\Is\\The\\Namespace\\ClassName');

        $this->assertSame('ClassName', $actual);
    }

    /**
     * @test
     */
    public function getClassNameWithoutNamespaceReturnsCorrectResultWithNoNamespacedClass(): void
    {
        $actual = Utility::getClassNameWithoutNamespace('ClassName');

        $this->assertSame('ClassName', $actual);
    }

    /**
     * @test
     */
    public function getNamespacedClassNameForType(): void
    {
        $actual = Utility::getNamespacedClassNameForType('Thing');

        $this->assertSame(Thing::class, $actual);
    }

    /**
     * @test
     */
    public function getNamespacedClassNameForTypeReturnsNullIftypeDoesNotExist(): void
    {
        $actual = Utility::getNamespacedClassNameForType('DoesNotExist');

        $this->assertNull($actual);
    }

    /**
     * @test
     */
    public function setNamespaceForTypesReturnsOriginalNamespace(): void
    {
        $originalNamespace = Utility::setNamespaceForTypes('\\Some\\Namespace');

        $this->assertSame('Brotkrueml\\Schema\\Model\\Type', $originalNamespace);

        Utility::setNamespaceForTypes($originalNamespace);
    }
}
