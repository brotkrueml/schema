<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Registry;

use Brotkrueml\Schema\Registry\TypeRegistry;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\FixtureImage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\VideoGallery;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\WebPage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
use TYPO3\CMS\Core\Package\PackageInterface;
use TYPO3\CMS\Core\Package\PackageManager;

/**
 * @runTestsInSeparateProcesses
 */
class TypeRegistryTest extends TestCase
{
    /** @var TypeRegistry */
    private $subject;

    /** @var MockObject|PhpFrontend */
    private $cacheMock;

    protected function setUp(): void
    {
        $this->cacheMock = $this->createMock(PhpFrontend::class);

        $packageStub1 = $this->createStub(PackageInterface::class);
        $packageStub1
            ->method('getPackagePath')
            ->willReturn(__DIR__ . '/../../Fixtures/');

        $packageStub2 = $this->createStub(PackageInterface::class);
        $packageStub2
            ->method('getPackagePath')
            ->willReturn(__DIR__ . '/NotExisting/');

        $packageManagerStub = $this->createStub(PackageManager::class);
        $packageManagerStub
            ->method('getActivePackages')
            ->willReturn([$packageStub1, $packageStub2]);

        $this->subject = new TypeRegistry($this->cacheMock, $packageManagerStub);
    }

    /**
     * @test
     */
    public function getTypesReturnsTypesFromCacheCorrectly(): void
    {
        $this->cacheMock
            ->expects(self::once())
            ->method('has')
            ->with('types')
            ->willReturn(true);

        $this->cacheMock
            ->expects(self::once())
            ->method('require')
            ->with('types')
            ->willReturn([
                'FixtureImage' => FixtureImage::class,
                'VideoGallery' => VideoGallery::class,
                'WebPage' => WebPage::class,
            ]);

        $this->cacheMock
            ->expects(self::never())
            ->method('set');

        $actual = $this->subject->getTypes();

        self::assertSame(['FixtureImage', 'VideoGallery', 'WebPage'], $actual);
    }

    /**
     * @test
     */
    public function getTypesReturnsTypesWithReadingConfiguration(): void
    {
        $this->cacheMock
            ->expects(self::once())
            ->method('has')
            ->with('types')
            ->willReturn(false);

        $this->cacheMock
            ->expects(self::never())
            ->method('require');

        $this->cacheMock
            ->expects(self::once())
            ->method('set')
            ->with(
                'types',
                "return array (
  'BreadcrumbList' => 'Brotkrueml\\\\Schema\\\\Tests\\\\Fixtures\\\\Model\\\\Type\\\\BreadcrumbList',
  'FixtureImage' => 'Brotkrueml\\\\Schema\\\\Tests\\\\Fixtures\\\\Model\\\\Type\\\\FixtureImage',
  'FixtureThing' => 'Brotkrueml\\\\Schema\\\\Tests\\\\Fixtures\\\\Model\\\\Type\\\\FixtureThing',
  'Table' => 'Brotkrueml\\\\Schema\\\\Tests\\\\Fixtures\\\\Model\\\\Type\\\\Table',
  'WebPage' => 'Brotkrueml\\\\Schema\\\\Tests\\\\Fixtures\\\\Model\\\\Type\\\\WebPage',
  'WebSite' => 'Brotkrueml\\\\Schema\\\\Tests\\\\Fixtures\\\\Model\\\\Type\\\\WebSite',
);"
            );

        $actual = $this->subject->getTypes();

        self::assertSame(['BreadcrumbList', 'FixtureImage', 'FixtureThing', 'Table', 'WebPage', 'WebSite'], $actual);
    }

    /**
     * @test
     */
    public function getTypesReturnsTypesFromClassVariableWhenCalledTheSecondTime(): void
    {
        $this->cacheMock
            ->expects(self::once())
            ->method('has')
            ->with('types')
            ->willReturn(false);

        $this->subject->getTypes();
        $actual = $this->subject->getTypes();

        self::assertSame(['BreadcrumbList', 'FixtureImage', 'FixtureThing', 'Table', 'WebPage', 'WebSite'], $actual);
    }

    /**
     * @test
     */
    public function getWebPageTypesReturnsTypesFromCacheCorrectly(): void
    {
        $this->cacheMock
            ->expects(self::once())
            ->method('has')
            ->with('webpage_types')
            ->willReturn(true);

        $this->cacheMock
            ->expects(self::once())
            ->method('require')
            ->with('webpage_types')
            ->willReturn([
                'VideoGallery',
                'WebPage',
            ]);

        $actual = $this->subject->getWebPageTypes();

        self::assertSame(['VideoGallery', 'WebPage'], $actual);
    }

    /**
     * @test
     */
    public function getWebPageTypesLoadsTypesNotFromCache(): void
    {
        $this->cacheMock
            ->method('has')
            ->willReturn(false);

        $actual = $this->subject->getWebPageTypes();

        self::assertSame(['WebPage'], $actual);
    }

    /**
     * @test
     */
    public function getWebPageTypesReturnsTypesFromClassVariableWhenCalledTheSecondTime(): void
    {
        $this->cacheMock
            ->expects(self::exactly(2)) // on webpage_types and types once
            ->method('has')
            ->willReturn(false);

        $this->subject->getWebPageTypes();
        $actual = $this->subject->getWebPageTypes();

        self::assertSame(['WebPage'], $actual);
    }

    /**
     * @test
     */
    public function getWebPageElementTypesReturnsTypesFromCacheCorrectly(): void
    {
        $this->cacheMock
            ->expects(self::once())
            ->method('has')
            ->with('webpageelement_types')
            ->willReturn(true);

        $this->cacheMock
            ->expects(self::once())
            ->method('require')
            ->with('webpageelement_types')
            ->willReturn([
                'Table',
                'WebPageElement',
            ]);

        $actual = $this->subject->getWebPageElementTypes();

        self::assertSame(['Table', 'WebPageElement'], $actual);
    }

    /**
     * @test
     */
    public function getWebPageElementTypesLoadsTypesNotFromCache(): void
    {
        $this->cacheMock
            ->method('has')
            ->willReturn(false);

        $actual = $this->subject->getWebPageElementTypes();

        self::assertSame(['Table'], $actual);
    }

    /**
     * @test
     */
    public function getWebPageElementTypesReturnsTypesFromClassVariableWhenCalledTheSecondTime(): void
    {
        $this->cacheMock
            ->expects(self::exactly(2)) // on webpageelement_types and types once
            ->method('has')
            ->willReturn(false);

        $this->subject->getWebPageElementTypes();
        $actual = $this->subject->getWebPageElementTypes();

        self::assertSame(['Table'], $actual);
    }

    /**
     * @test
     */
    public function getContentTypesReturnsOnlyTheContentTypes(): void
    {
        $this->cacheMock
            ->expects(self::exactly(3)) // on webpage_types, webpageelement_types and types once
            ->method('has')
            ->willReturn(false);

        $actual = $this->subject->getContentTypes();

        self::assertSame(['FixtureImage', 'FixtureThing'], $actual);
    }

    /**
     * @test
     */
    public function resolveModelClassFromTypeReturnsCorrectModel(): void
    {
        $this->cacheMock
            ->method('has')
            ->willReturn(false);

        $actual = $this->subject->resolveModelClassFromType('FixtureImage');

        self::assertSame(FixtureImage::class, $actual);
    }

    /**
     * @test
     */
    public function resolveModelClassFromTypeReturnsNullWhenTypeNotAvailable(): void
    {
        $this->cacheMock
            ->method('has')
            ->willReturn(false);

        $actual = $this->subject->resolveModelClassFromType('NotConfiguredType');

        self::assertNull($actual);
    }

    /**
     * @test
     */
    public function resolveModelClassFromTypeReturnsNullWhenTypeIsEmpty(): void
    {
        $this->cacheMock
            ->method('has')
            ->willReturn(false);

        $actual = $this->subject->resolveModelClassFromType('');

        self::assertNull($actual);
    }
}
