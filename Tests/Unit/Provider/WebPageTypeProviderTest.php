<?php

namespace Brotkrueml\Schema\Tests\Unit\Provider;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use PHPUnit\Framework\TestCase;

class WebPageTypeProviderTest extends TestCase
{
    protected $webPageTypes = [
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

    /**
     * We have to assure that no WebPage type is removed by the generator
     * when the schema definition changes. A WebPage type can be assigned
     * by the user in the page field!
     *
     * @test
     * @covers \Brotkrueml\Schema\Provider\WebPageTypeProvider::getTypes
     */
    public function getTypesReturnsAllCurrentWebTypes(): void
    {
        $actual = WebPageTypeProvider::getTypes();

        $this->assertSame($this->webPageTypes, $actual);
    }

    /**
     * We also have to assure that the structure for the TCA is correct
     * and has also the empty option available!
     *
     * @test
     * @covers \Brotkrueml\Schema\Provider\WebPageTypeProvider::getTypesForTcaSelect
     */
    public function getTypesForTcaSelectReturnsCorrectStructure(): void
    {
        $expected = [['', '']];
        foreach ($this->webPageTypes as $webPageType) {
            $expected[] = [$webPageType, $webPageType];
        }

        $actual = WebPageTypeProvider::getTypesForTcaSelect();

        $this->assertSame($expected, $actual);
    }
}
