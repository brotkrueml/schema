<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Provider;

use Brotkrueml\Schema\Provider\TypesProvider;
use Brotkrueml\Schema\Registry\TypeRegistry;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TypesProviderTest extends TestCase
{
    /** @var TypeRegistry|Stub */
    private $typeRegistryStub;

    /** @var TypesProvider */
    private $subject;

    protected function setUp(): void
    {
        $this->typeRegistryStub = $this->createStub(TypeRegistry::class);
        GeneralUtility::setSingletonInstance(TypeRegistry::class, $this->typeRegistryStub);

        $this->subject = new TypesProvider();
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function getTypes(): void
    {
        $this->expectDeprecation();

        $this->typeRegistryStub
            ->expects(self::once())
            ->method('getTypes')
            ->willReturn(['sometype']);

        self::assertSame(['sometype'], $this->subject->getTypes());
    }

    /**
     * @test
     */
    public function getWebPageTypes(): void
    {
        $this->expectDeprecation();

        $this->typeRegistryStub
            ->expects(self::once())
            ->method('getWebPageTypes')
            ->willReturn(['somewebpagetype']);

        self::assertSame(['somewebpagetype'], $this->subject->getWebPageTypes());
    }

    /**
     * @test
     */
    public function getWebPageElementTypes(): void
    {
        $this->expectDeprecation();

        $this->typeRegistryStub
            ->expects(self::once())
            ->method('getWebPageElementTypes')
            ->willReturn(['somewebpageelementtype']);

        self::assertSame(['somewebpageelementtype'], $this->subject->getWebPageElementTypes());
    }

    /**
     * @test
     */
    public function getContentTypes(): void
    {
        $this->expectDeprecation();

        $this->typeRegistryStub
            ->expects(self::once())
            ->method('getContentTypes')
            ->willReturn(['somecontentype']);

        self::assertSame(['somecontentype'], $this->subject->getContentTypes());
    }
}
