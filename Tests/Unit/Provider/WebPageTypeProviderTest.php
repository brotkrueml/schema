<?php

namespace Brotkrueml\Schema\Tests\Unit\Provider;

use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use Brotkrueml\Schema\Utility\Utility;
use PHPUnit\Framework\TestCase;

class WebPageTypeProviderTest extends TestCase
{
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
            $key = sprintf('Type "%s"', $type);

            yield $key => [$type];
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
