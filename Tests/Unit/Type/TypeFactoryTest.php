<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Type;

use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Type\TypeFactory;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TypeFactoryTest extends TestCase
{
    use SchemaCacheTrait;

    /**
     * @var TypeRegistry|Stub
     */
    private $typeRegistryStub;

    protected function setUp(): void
    {
        $this->typeRegistryStub = $this->createStub(TypeRegistry::class);
        GeneralUtility::setSingletonInstance(TypeRegistry::class, $this->typeRegistryStub);

        $this->defineCacheStubsWhichReturnEmptyEntry();
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function createTypeReturnsInstanceOfTypeModel(): void
    {
        $this->typeRegistryStub
            ->method('resolveModelClassFromType')
            ->with('Thing')
            ->willReturn(Thing::class);

        $type = TypeFactory::createType('Thing');

        self::assertInstanceOf(Thing::class, $type);
    }

    /**
     * @test
     */
    public function createTypeThrowsExceptionOnInvalidType(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(1586590157);
        $this->expectExceptionMessage('No model class for type "UnavailableThing" available!');

        $this->typeRegistryStub
            ->method('resolveModelClassFromType')
            ->with('UnavailableThing')
            ->willReturn(null);

        TypeFactory::createType('UnavailableThing');
    }

    /**
     * @test
     */
    public function instantiatingTypeFactoryThrowsError(): void
    {
        $this->expectException(\Error::class);

        new TypeFactory();
    }
}
