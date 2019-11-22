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

        self::assertSame('ClassName', $actual);
    }

    /**
     * @test
     */
    public function getClassNameWithoutNamespaceReturnsCorrectResultWithNoNamespacedClass(): void
    {
        $actual = Utility::getClassNameWithoutNamespace('ClassName');

        self::assertSame('ClassName', $actual);
    }

    /**
     * @test
     */
    public function getNamespacedClassNameForType(): void
    {
        $actual = Utility::getNamespacedClassNameForType('Thing');

        self::assertSame(Thing::class, $actual);
    }

    /**
     * @test
     */
    public function getNamespacedClassNameForTypeReturnsNullIftypeDoesNotExist(): void
    {
        $actual = Utility::getNamespacedClassNameForType('DoesNotExist');

        self::assertNull($actual);
    }

    /**
     * @test
     */
    public function setNamespaceForTypesReturnsOriginalNamespace(): void
    {
        $originalNamespace = Utility::setNamespaceForTypes('\\Some\\Namespace');

        self::assertSame('Brotkrueml\\Schema\\Model\\Type', $originalNamespace);

        Utility::setNamespaceForTypes($originalNamespace);
    }
}
