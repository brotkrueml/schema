<?php

namespace Brotkrueml\Schema\Tests\Unit\Provider;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use Brotkrueml\Schema\Utility\Utility;
use PHPUnit\Framework\TestCase;

class WebPageTypeProviderTest extends TestCase
{
    public function dataProvider(): array
    {
        $webPageTypes = [
            'AboutPage',
            'CheckoutPage',
            'CollectionPage',
            'ContactPage',
            'FAQPage',
            'ImageGallery',
            'ItemPage',
            'ProfilePage',
            'QAPage',
            'SearchResultsPage',
            'VideoGallery',
            'WebPage',
        ];

        $result = [];

        foreach ($webPageTypes as $type) {
            $key = sprintf('Type "%s"', $type);

            $result[$key] = [$type];
        }

        return $result;
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

        $this->assertInstanceOf(WebPageTypeInterface::class, $class);
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

        $this->assertContains([$type, $type], $actual);
    }

    /**
     * @test
     */
    public function getTypesForTcaSelectHasEmptyOption(): void
    {
        $actual = WebPageTypeProvider::getTypesForTcaSelect();

        $this->assertContains(['', ''], $actual);
    }
}
