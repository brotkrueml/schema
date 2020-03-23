<?php

namespace Brotkrueml\Schema\Tests\Unit\Provider;

use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use Brotkrueml\Schema\Registry\TypeRegistry;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WebPageTypeProviderTest extends TestCase
{
    protected $availableWebPageTypesForTesting = [
        'FooPage',
        'BarPage',
        'SomePage',
        'AnotherPage',
    ];

    protected function setUp(): void
    {
        $typeRegistryStub = $this->createStub(TypeRegistry::class);
        $typeRegistryStub
            ->method('getWebPageTypes')
            ->willReturn($this->availableWebPageTypesForTesting);

        GeneralUtility::setSingletonInstance(TypeRegistry::class, $typeRegistryStub);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    public function dataProvider(): iterable
    {
        foreach ($this->availableWebPageTypesForTesting as $type) {
            yield \sprintf('Type "%s"', $type) => [$type];
        }
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param string $type
     */
    public function getTypesForTcaSelectReturnsAllAvailableWebPageTypes(string $type): void
    {
        $actual = WebPageTypeProvider::getTypesForTcaSelect();

        self::assertContains([$type, $type], $actual);
    }

    /**
     * @test
     */
    public function getTypesForTcaSelectHasEmptyOption(): void
    {
        $actual = WebPageTypeProvider::getTypesForTcaSelect();

        self::assertContains(['', ''], $actual);
    }
}
