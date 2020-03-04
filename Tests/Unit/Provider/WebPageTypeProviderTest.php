<?php

namespace Brotkrueml\Schema\Tests\Unit\Provider;

use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use Brotkrueml\Schema\Utility\Utility;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WebPageTypeProviderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();
    }

    protected function defineCacheStubsWhichReturnEmptyEntry(): void
    {
        $cacheFrontendStub = $this->createStub(FrontendInterface::class);
        $cacheFrontendStub
            ->method('get')
            ->willReturn([]);

        $cacheManagerStub = $this->createStub(CacheManager::class);
        $cacheManagerStub
            ->method('getCache')
            ->with('tx_schema')
            ->willReturn($cacheFrontendStub);

        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerStub);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
    }

    public function dataProvider(): iterable
    {
        $webPageTypes = [
            'AboutPage',
            'CheckoutPage',
            'CollectionPage',
            'ContactPage',
            'FAQPage',
            'ImageGallery',
            'ItemPage',
            'MediaGallery',
            'ProfilePage',
            'QAPage',
            'SearchResultsPage',
            'VideoGallery',
            'WebPage',
        ];

        foreach ($webPageTypes as $type) {
            yield \sprintf('Type "%s"', $type) => [$type];
        }
    }

    /**
     * We have to assure that no WebPage type is removed by the generator
     * when the schema definition changes. A WebPage type can be assigned
     * by the user in the page field!
     *
     * @test
     * @dataProvider dataProvider
     *
     * @param string $type
     */
    public function givenWebPageTypeIsAnInstanceOfWebPageTypeInterface(string $type): void
    {
        $className = Utility::getNamespacedClassNameForType($type);
        $class = new $className();

        self::assertInstanceOf(WebPageTypeInterface::class, $class);
    }

    /**
     * We also have to assure that the structure for the TCA is correct
     * and has also the empty option available!
     *
     * @test
     * @dataProvider dataProvider
     *
     * @param string $type
     */
    public function givenTypeIsInTcaSelect(string $type): void
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
